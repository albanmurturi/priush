<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Act;
use App\Action;
use App\Subcategory;
use Carbon\Carbon;
use App\Http\Controllers\SomeMethodsController as SMC;

class ActsController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function index(){
        $priorities = auth()->user()->priorities()->get();
        
        $subcategories = auth()->user()->subcategories()->get();

        $acts = auth()->user()->acts()->get();

        if(!count($priorities)) {

            $here = '<a href="' . url('\priorities\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any priority yet, start creating new ' . $here);

            return view('acts.acts')->with(compact('acts'));
        }

        if(!count($subcategory)) {
            
            $here = '<a href="' . url('\subcategories\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any subcategory yet, start creating new ' . $here);

            return view('acts.acts')->with(compact('acts'));

        }

        if(!count($acts)) {
            
            $here = '<a href="' . url('\acts\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any act yet, start creating new ' . $here);

            return view('acts.acts')->with(compact('acts'));

        }


        return view('acts.acts', compact('acts'));
    }

    public function show(Act $act) {

        $pass_key = true;

        if(auth()->id() != $act->user_id) {

            $pass_key = false;

            session()->flash('failure', 'You do not have permission to see this action, probably is not your action or it may be deleted before');

            return view('acts.act', compact('pass_key'));
        } else  {

            $calculatedData = array();

            $actionsByMonths = auth()->user()->actions()
                            ->selectRaw('year(created_at) year, monthname(created_at) month')
                            ->groupBy('year', 'month')
                            ->orderByRaw('min(created_at) desc')
                            ->get()
                            ->toArray();

            $actionsByYears = auth()->user()->actions()
                            ->selectRaw('year(created_at) year')
                            ->groupBy('year')
                            ->orderByRaw('min(created_at) desc')
                            ->get()
                            ->toArray();

            $actions = $act->actions()
                ->orderByRaw('date asc');  

            if(!request('month') && !request('year') ) {
                $now = Carbon::now();
                $month = $now->format('F');
                $year = $now->year;
                $actions = $actions->whereMonth('date', Carbon::parse($month)->month)->whereYear('created_at', $year);
            } else {

                if($month = request('month')) {
                    $actions = $actions->whereMonth('date', Carbon::parse($month)->month);
                } 

                if($year = request('year')) {
                   $actions = $actions->whereYear('date', $year);
                } 
            }       

            $actions = $actions->get();

            $tempActions = $actions;
            $all = count($tempActions);

            if($all == 0){

                session()->flash('failure', 'This Act has not any data for this filter');
                return view('acts.act', compact('act', 'actions', 'actionsByMonths', 'actionsByYears', 'pass_key'));
            } 

            $total = count($tempActions->where('is_done', 1));
            $average_percentage = intval(round($total/$all*100));
            $calculatedData += [
                'color'                 => SMC::getColorClassName($average_percentage),
                'filter'                => $month . ' ' . $year,
                'average_percentage'    => $average_percentage,
                'total'                 => $total,
                'all'                   => $all
                ];

            $actions->toArray();

            $acts = auth()->user()->acts()->idAndName();

            return view('acts.act', compact('act', 'actions', 'actionsByMonths', 'actionsByYears', 'calculatedData', 'pass_key'));
        }

        return redirect('/');
    }

    public function create(){
        
        $priorities = auth()->user()->priorities()->get();
        
        $subcategories = auth()->user()->subcategories()->get();

        $acts = auth()->user()->acts()->get();

        if(!count($priorities)) {

            $here = '<a href="' . url('\priorities\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any priority yet, start creating new ' . $here);

            return view('acts.create', compact('subcategories'));
        }

        if(!count($subcategory)) {
            
            $here = '<a href="' . url('\subcategories\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any subcategory yet, start creating new ' . $here);

            return view('acts.create', compact('subcategories'));

        }

        if(!count($acts)) {
            
            $here = '<a href="' . url('\acts\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any act yet, start creating new ' . $here);

            return view('acts.create', compact('subcategories'));

        }

    	return view('acts.create', compact('subcategories'));
    }

    public function store(){

        $this->validate(request(),[
            'subcategory_id'=>'required',
            'name'=>'required'

            ]);
        $subcategory = Subcategory::where('id', request('subcategory_id'))->first();

        if(auth()->id() == $subcategory->user_id) {

            auth()->user()->addAct(
                new Act(request(['subcategory_id', 'name']))
            );

            session()->flash('message', 'Act has been created with success!');

            return redirect('acts');
        }
    	
    }


    public function destroy(Act $act){

        if(auth()->id() == $act->subcategory()->first()->user_id){
            $act->delete();


            session()->flash('message', 'Act has been deleted with success!');

            return redirect('acts');
        }
    }

    public function update(Request $request,Act $act){

        if(auth()->id() == $act->subcategory()->first()->user_id){

            $this->validate(request(), [
                'name'=>'required'
            ]);

            $act->update([
                'name' => $request->name,
            ]);

            session()->flash('message', 'Act has been edited with success!');

            return redirect('acts/' . $act->id);
        }
    }
    
}
