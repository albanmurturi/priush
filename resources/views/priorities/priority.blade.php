@extends('adminlte::page')

@section('title', 'Priority: ' . $priority->name)

@section('content_header')

  <h1><a href="{{url('/priorities')}}">Priorities</a> - Priority: <a href="#">{{$priority->name}}</a>
    <a class="btn btn-info btn-xs" href="{{ url('/priorities/' . $priority->id . '/edit')}}">
      <i class="glyphicon glyphicon-edit"></i> Edit
    </a>

  	<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal" data-url="{{ URL::route('priority-delete', $priority->id) }}">
      <i class="glyphicon glyphicon-trash"></i> Delete
    </a> 
	</h1>
	
@stop

@section('content')	
<div class="container">
<div class="panel-group col-lg-6 col-md-6 col-sm-6"" id="accordion">
    <div class="panel panel-default">

<h4>Subcategories:</h4>
  @foreach($priority->subcategories as $key => $subcategory)
    <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}"style="float:right">
              <i class="fa fa-toggle-down" ></i>
            </a>
            <a href="{{ url('subcategories/' . $subcategory->id) }}">
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
		<a href="<?php echo url('priorities/create')?>" class="btn btn-default btn-circle"><i class="glyphicon glyphicon-plus"></i></a>
	</div>	

<!-- Modal -->
<form action="{{url('/priorities/' . $priority->id)}}" method="POST" class="remove-record-model">
    @method('delete')	

    {{ csrf_field() }}

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Security step
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h3>
        </div>
        <div class="modal-body">
          Are you sure you want to delete priority: {{$priority->name}} 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>
</form>
		
@stop

@section('css')
	
    <link rel="stylesheet" href="{{ asset('/css/crud.css') }}">
    <style type="text/css">
       p.tab-space {padding-right:5em;}
      p.double-tab-space {padding-left:8em;}
    </style>
@stop

@section('js')

@stop

@push('css')

@push('js')