@extends('adminlte::page')

@section('title', 'Create Priority')

@section('content_header')
    <h1> Edit Priority {{$priority->name}}

	</h1>
@stop


@section('content')
	
	<div class="col-sm-6 blog-main">

	<div class="blog-post">

			<form method="POST" action="{{url('/priorities/' . $priority->id) }}">

					{{ csrf_field() }}

				<input type="hidden" name="_method" value="put">
	
				<div class="form-group">
				   <label for="Name">Name:</label>
				   <input type="text" class="form-control" name="name" id="name" value="{{$priority->name}}">
				</div>

				<div class="form-group" >
					<button type="submit" class="btn btn-info">Save</button>
				</div>
				
			</form>

			@include('layouts.error')
	</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('\css\crud.css')}}">
@stop

@section('js')

@stop

@push('css')

@push('js')