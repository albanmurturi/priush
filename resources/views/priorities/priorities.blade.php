@extends('adminlte::page')

@section('title', 'Pirorities')

@section('content_header')
    <h1> Priorities </h1>
@stop

@section('content')	
<div class="container">
<div class="panel-group col-lg-6 col-md-6 col-sm-6" id="accordion">
	@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
    
	@foreach($priorities as $key => $priority)
	<div class="panel panel-default ">
      <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" style="float:right">
          		<i class="fa fa-toggle-down" ></i>
            </a>
    		<a href="priorities/{{$priority->id}}">
				<li>{{ $priority->name }}</li>
			</a>
        </h4>
      </div>
      <div id="collapse{{$key}}" class="panel-collapse collapse">
        <div class="panel-body">
        	<ul>
		@foreach($priority->subcategories as $subcategory)
			<h4 >
				<a href="subcategories/{{$subcategory->id}}">
					<li>{{ $subcategory->name . ' (subcategory)'}}</li>
				</a>
				
			</h4>		
			@foreach($subcategory->acts as $act)
				<p >
					<a href="acts/{{$act->id}}">
						<li>{{ $act->name . ' (act)'}}</li>
					</a>
					
				</p>
			@endforeach
		@endforeach
	</ul>	
		</div>
	</div>
	@endforeach

</div>

</div>
	<div>
		<a href="<?php echo url('priorities/create')?>" class="btn btn-default btn-circle"><i class="glyphicon glyphicon-plus"></i></a>
	</div>		
</div>
@stop

@section('css')
	
    <link rel="stylesheet" href="{{ asset('/css/crud.css') }}">

@stop

@section('js')

@stop

@push('css')

@push('js')