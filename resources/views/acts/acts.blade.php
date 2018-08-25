@extends('adminlte::page')

@section('title', 'Acts')

@section('content_header')
    <h1> Acts

	</h1>
@stop

@section('content')
@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
	@foreach($acts as $act)
		<li><a href="acts/{{$act->id}}">{{ $act->name}}</a></li>
	@endforeach

	<div>
		<a class="btn btn-default btn-circle" href="{{ url('/acts/create')}}">
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