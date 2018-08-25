@extends('adminlte::page')

@section('title', 'Subcategories')

@section('content_header')
    <h1><a href="{{url('/priorities')}}">Priorities</a> - <a href="{{url('/subcategories')}}">Subcategories</a> 

	</h1>
@stop

@section('content')
<div class="container">
	@if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
<div class="panel-group col-lg-6 col-md-6 col-sm-6" id="accordion">
    <div class="panel panel-default">
    <h3> Subcategories: </h3>
	@foreach($subcategories as $key => $subcategory)
		<div class="panel-heading">
	        <h4 class="panel-title">
	          	<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}"style="float:right">
          			<i class="fa fa-toggle-down" ></i>
            	</a>
	          <a href="subcategories/{{$subcategory->id}}">

				<li>{{ $subcategory->name}}</li>
			</a>
	        </h4>
	    </div>
		<div id="collapse{{$key}}" class="panel-collapse collapse">
        	<div class="panel-body">
				<ul>
					@foreach($subcategory->acts as $act)
						<p class="double-tab-space">
							<a href="{{ url('acts/' . $act->id) }}">
								<li>{{ $act->name . ' (act)'}}</li>
							</a>
					
						</p>
					@endforeach
				</ul>
			</div>	
		</div>		
	@endforeach
	</div>
</div>
</div>
<div>
	<a class="btn btn-default btn-circle" href="{{url('subcategories/create')}}">
		<i class="glyphicon glyphicon-plus"></i>
	</a>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/crud.css')}}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

@push('css')

@push('js')