<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Action;
use App\Act;
use Carbon\Carbon;
use App\Http\Controllers\SomeMethodsController as SMC;

class ActionsController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function index(){

        $notNull = true;

        $actions = auth()->user()->actions()->actionsGrupedByDate();

    	$acts = auth()->user()->acts()->idAndName();
        

    	if(count($acts) == 0){

            $notNull = false;
    	   return view('/actions.actions', compact('notNull'))->withErrors([
    		'message' => 'You did not add any action yet']);
    	}


    	if(count($actions) == 0){

            $notNull = false;

    	   return view('/actions.actions', compact('notNull', 'acts'))->withErrors([
    		'message' => 'You did not add any actio yet']);
    	}

        $lastMonthActions = array();


        foreach($actions as $action){


            $aDayActions = array();

            $aDayActions += ['date' => $action['date']];

            $actionOnDate = auth()->user()->actions()->actionOnDate($action['date']);

            $i = count($actionOnDate);
            $done = 0;

                $values = array();
            // if(isset($values)){
            //    unset($values);
            // } else {
            //     $values = array();
            // }
            foreach($actionOnDate as $aod){
                array_push($values, $aod['is_done']);
                $done += $aod['is_done'];
            }
            
            $done = intval(round($done/$i*100));

            array_push($aDayActions, $values);
            $aDayActions += ['done'  => $done];
            $aDayActions += ['color'  => SMC::getColorClassName($done)];
            unset($values);
            array_push($lastMonthActions, $aDayActions);
            unset($aDayActions);
        }

        // dd($lastMonthActions);                  

    	return view('/actions.actions', compact('lastMonthActions', 'acts', 'notNull'));

    }

    public function showAtDay(Action $action) {

        $actions = auth()->user()->actions()
                                ->where('date', request('date'))
                                ->join('acts', 'actions.act_id', '=', 'acts.id')
                                ->selectRaw('actions.id, actions.date date, actions.is_done is_done, acts.name')
                                ->get()
                                ->toArray();

        return view('/actions.showAtDay', compact('actions'));
    }

    public function create() {

    	$acts = auth()->user()->acts()->get();
    	if(count($acts) == 0){

    		return view('/actions.create', compact('acts'))->withErrors([
    			'message' => 'Ju can not add actions without adding any act']);;
    	}
    	return view('/actions.create', compact('acts'));

    }

    public function store(Request $request) {

    	$this->validate($request, [
    		'date' => 'required'
    	]);
    	if(count(auth()->user()->actions()->where('date', request('date'))->get())){
    		// dd('didnt pass');
    		return back()->withErrors([
    			'message' => 'You have alredy registred datas with this date']);
    	}

    	// $today = Carbon::now()->toDateString();
    	// $count = count(request()->all()) - 2; 
    	// $request = $request;


    	// dd($request);
    	$acts = auth()->user()->acts()->get();

    	foreach($acts as $act) {
    		auth()->user()->actions()->create([
             'act_id' => $act->id,
             'is_done' => request($act->id),
             'date' => request('date')
             ]);
    	}

    	return redirect('/actions');

    }

    public function editOnDate() {
       
        $actions = auth()->user()->actions()
                                ->where('date', request('date'))
                                ->join('acts', 'actions.act_id', '=', 'acts.id')
                                ->selectRaw('acts.id, actions.date date, actions.is_done is_done, acts.name')
                                ->get()
                                ->toArray();

        return view('/actions.editAtDay', compact('actions'));
        
    }

    public function updateOnDate() {


        // $actions = auth()->user()->actions()->where('date', request('date'));

        $acts = auth()->user()->acts()->get()->toArray();

        foreach($acts as $act) {
            auth()->user()->actions()
                        ->where('date', request('date'))
                        ->where('act_id', $act['id'])
                        ->update([
                                        'is_done' => request($act['id']),
                                 ]);
        }
        return redirect('/action?date=' . request('date'));
        
    }

    public function destroyOnDate() {

        $actions = auth()->user()->actions()->where('date', request('date'));
        $actions->delete();
                
        return redirect('actions');
    }

    public function edit(Action $action) {
        // dd($action->id);

            if(auth()->id() == $action->user_id) {

                return view('actions.edit', compact('action'));
            }
            
            return back();
    }

    public function update(Action $action) {

        // dd(request()->all());

        if(auth()->id() == $action->user_id) {
                $action->update([
                    'is_done' => request('is_done'),
                ]);
                return redirect('action?date=' . $action->date);
            }
    }
}