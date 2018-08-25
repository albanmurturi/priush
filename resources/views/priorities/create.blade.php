@extends('adminlte::page')

@section('title', 'Create Priority')

@section('content_header')
    <h1> Create Priority

	</h1>
@stop


@section('content')
	
	<div class="col-sm-6 blog-main">

	<div class="blog-post">

			<form method="POST" action="<?php echo url('/priorities') ?>">

					{{ csrf_field() }}
	
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