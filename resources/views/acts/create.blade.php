@extends('adminlte::page')

@section('title', 'Create Act')

@section('content_header')
    <h1> Create Act

	</h1>
@stop

@section('content')
	

	<div class="col-sm-6 blog-main">

		@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif

	<div class="blog-post">

			<form method="POST" action="<?php echo url('/acts') ?>">

					{{ csrf_field() }} 
				
				 <div class="form-group">
				    <label for="Subcategory">Subcategory:</label>
				    <select type="number" class="form-control" name="subcategory_id" id="subcategory_id" >
				    	@foreach($subcategories as $subcategory)
				    		<option value="{{$subcategory->id}}"> {{$subcategory->name}} </option>
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

			@include('layouts/error')
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