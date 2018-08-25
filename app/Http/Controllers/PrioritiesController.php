<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Priority;
use App\Subcategory;
use App\Act;

class PrioritiesController extends Controller
{
    public function __construct(){

    	$this->middleware('auth');
    }

    public function index(){

    	$priorities = auth()->user()->priorities()->get();

        if(!count($priorities)) {

            $here = '<a href="' . url('\priorities\create') . '"">here</a>';
            session()->flash('failure', 'You do not have create any yet, start creating new ' . $here);

            return view('priorities.priorities')->with(compact('priorities'));
        }

    	return view('priorities.priorities')->with(compact('priorities'));
    }

    public function show(Priority $priority){

        if($priority->user_id == auth()->id()){

            return view('priorities.priority')->with(compact('priority'));
        } 

        return back();
    }

    public function create(){

        return view('priorities.create');
    }

    public function store(){

        $this->validate(request(), [
            'name' => 'required'
            ]);

        // dd(request()->all());

        auth()->user()->addPriority(
            new Priority(request(['name']))
        ); 

        session()->flash('message', 'The priority has been added with success!');

        return redirect('priorities');
    }

    public function edit(Priority $priority) {
        if(auth()->id() == $priority->user_id){
            return view('priorities.edit', compact('priority'));
        }

        return back();
    }

    public function update(Request $request,Priority $priority) {

        if(auth()->id() == $priority->user_id){

            $this->validate(request(), [
            'name' => 'required'
            ]);

            $priority->update([
                'name' => $request->name,
            ]);

            session()->flash('message', 'The priority has been edited with success!');
            return view('priorities.priority')->with(compact('priority'));
        }
    }

    public function destroy(Priority $priority){

        if(auth()->id() == $priority->user_id) {
            
            $priority->delete();

            session()->flash('message', 'The priority has been deleted.');
            
            return redirect('priorities');
        }
    }

}
