@extends('adminlte::page')

@section('title', 'Create Subcategory')

@section('content_header')
    <h1> Create subcategory

	</h1>
@stop

@section('content')
	

	<div class="col-sm-6 blog-main">

	<div class="blog-post">

		@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif

			<form method="POST" action="<?php echo url('/subcategories') ?>">

					{{ csrf_field() }}
				
				 <div class="form-group">
				    <label for="Priority">Priority:</label>
				    <select type="number" class="form-control" name="priority_id" id="priority_id" >
				    	@foreach($priorities as $priority)
				    		<option value="{{$priority->id}}"> {{$priority->name}} </option>
				    	@endforeach
				    </select>
				 </div>

				 <div class="form-group">
				    <label for="Name">Name:</label>
				    <input type="text" class="form-control" name="name" id="name" >
				 </div>

				 <div class="form-group" >
				 	<button type="submit" class="btn btn-primary">Publish</button>
				 </div>
				
			</form>

			@include('layouts.error')
	</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop

@push('css')

@push('js')