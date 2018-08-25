@extends('adminlte::page')

@if($pass_key)

@section('title', 'Subcategory: ' . $subcategory->name)

@section('content_header')
    <h1> <a href="{{url('/priorities')}}">Priorities</a> - <a href="{{url('/subcategories')}}">Subcategories</a> Subcategory: <a href="">{{$subcategory->name}}</a>
	<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#exampleModal1" >
        <i class="glyphicon glyphicon-edit"></i> Edit
    </a>
	<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal" >
	    <i class="glyphicon glyphicon-trash"></i> Delete
    </a> 
	</h1>
@stop

@endif

@section('content')
	@if (Session::has('success'))
            <div class="alert alert-success">{!! Session::get('success') !!}</div>
    @endif
    @if (Session::has('failure'))
        <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
    @endif


@if($pass_key)    
	<h4>Acts:</h4>

	<ul>
		
	@foreach($subcategory->acts as $act)

		<a href="{{ url('acts/' . $act->id) }}">

			<li>{{ $act->name}}</li>
		</a>
	
	@endforeach

	</ul>

<form action="{{url('/subcategories/' . $subcategory->id)}}" method="POST" class="remove-record-model">
	@method('delete')	

	{{ csrf_field() }}

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Security step
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    	</h5>
	      </div>
	      <div class="modal-body">
	        Are you sure you want to delete priority: {{$subcategory->name}} 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-danger">Delete</button>
	      </div>
	    </div>
	  </div>
</div>
</form>

<form action="{{url('/subcategories/' . $subcategory->id)}}" method="POST" class="remove-record-model">
	@method('PUT')	

	{{ csrf_field() }}

	<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title" id="exampleModalLabel">Edit subcategory: {{$subcategory->name}} 
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        </h3>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
				<label for="Name">Name:</label>
				<input type="text" class="form-control" name="name" id="name" value="{{$subcategory->name}}">
			</div> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-info">Edit</button>
	      </div>
	    </div>
	  </div>
</div>
</form>


@endif	

	<div>
		<a class="btn btn-default btn-circle" href="{{ url('/subcategories/create')}}">
			<i class="glyphicon glyphicon-plus"></i>
		</a>
	</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('/css/crud.css')}}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

@push('css')

@push('js')