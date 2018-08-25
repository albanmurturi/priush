<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Subcategory;
use App\Act;
use App\Priority;

class SubcategoriesController extends Controller
{   
    protected $pass_key;
    
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index() {

        $priorities = auth()->user()->priorities()->get();
        
        $subcategories = auth()->user()->subcategories()->get();

        if(!count($priorities)) {

            $here = '<a href="' . url('\priorities\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any priority yet, start creating new ' . $here);

            return view('subcategories.subcategories')->with(compact('subcategories'));
        }


        if(!count($subcategory)) {
            
            $here = '<a href="' . url('\subcategories\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any subcategory yet, start creating new ' . $here);

            return view('subcategories.subcategories')->with(compact('subcategories'));

        }



    	return view('subcategories.subcategories', compact('subcategories'));
    }

    public function show(Subcategory $subcategory){

        if($subcategory->user_id == auth()->id()){

            $pass_key = true;

            return view('subcategories.subcategory', compact('subcategory', 'pass_key'));
        } else {

            $pass_key = false;
            session()->flash('failure', 'You do not have permission to see this subcategory, propably it is not your subcategory or you had deleted it before!');
            // dd($pas_key);
            return view('subcategories.subcategory', compact('pass_key'));
        }

    }


    public function create(){

        $priorities = auth()->user()->priorities()->get();

        return view('subcategories.create', compact('priorities'));

    }

    public function store() {

        $this->validate(request(), [
            'priority_id'=>'required',
            'name'=>'required',

            ]);

        // dd(request()->all());

        $priority = Priority::where('id', request('priority_id'))->first();
        // dd($priority);
        if(auth()->id() == $priority->user_id) {

            auth()->user()->addSubcategory(
                new Subcategory(request(['priority_id', 'name']))

            );

            session()->flash('message', 'Subcategory added with success!');

            return redirect('subcategories');
        }
    }

    public function destroy(Subcategory $subcategory){

        if(auth()->id() == $subcategory->user_id){
            $subcategory->delete();

            session()->flash('message', 'Subcategory deleted with success!');

            return redirect('subcategories');
        }
    }

    public function update(Request $request,Subcategory $subcategory){
        
        if(auth()->id() == $subcategory->user_id){

            $subcategory->update([
                'name' => $request->name,
            ]);

            session()->flash('message', 'Subcategory updated with success!');

            return redirect('subcategories/' . $subcategory->id);
        }
    }
}
