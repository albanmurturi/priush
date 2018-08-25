@extends('adminlte::page')

@section('title', 'A day performance')

@section('content_header')
    <h1> Actions on date: {{$actions[0]['date']}}
      <a class="btn btn-info btn-xs" href="{{ url('/actions/editOnDate?date=' . $actions[0]['date'])}}">
        <i class="glyphicon glyphicon-edit"></i> Edit
      </a>
      <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal">
        <i class="glyphicon glyphicon-trash"></i> Delete
      </a> 
    </h1>
@stop

@section('content')
  

  <div class="blog-main" style="min-height:100%">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Actions on date: {{$actions[0]['date']}}</h3>
        <a class="btn btn-info btn-sm" href="{{ url('/actions/editOnDate?date=' . $actions[0]['date'])}}" style="float:right;">
          <i class="glyphicon glyphicon-edit"> Edit</i>
        </a>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered">
          <tbody>
            <tr>

            <th style="width: 50px">
                Nr.
              </th>
            <th>
                Name
              </th>
            <th>is done </th>
            <th>Edit </th>
          </tr>

            @foreach($actions as $key => $action)
            <tr>
            

              <td >{{$key+1}}</td>

            
              <td >
                {{$action['name']}}
              </td>
              <td class="text-center" style="background-color: {{($action['is_done'])?'#00a65a':'#dd4b39'}}; width: 100px; ">
                {{$action['is_done']}}
              </td>
              <td style="width: 50px"> <a class="btn btn-info btn-xs" href="{{ url('/actions/' . $action['id'] . '/edit')}}">
        <i class="glyphicon glyphicon-edit"></i> Edit
      </a> </td>
              
            </tr>
           @endforeach
            
          </tbody>
        </table>


  @include('layouts/error')

  <form action="{{url('/actions/delete?date=' . $actions[0]['date'])}}" method="POST" class="remove-record-model">
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
            Are you sure you want to delete all actions on date: {{$actions[0]['date']}} 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>
</form>

  
</div>

@stop

@section('css')
    <style type="text/css">
      td {
        padding: 1px !important;
      }
    </style>
@stop

@section('js')


@stop

@push('css')

@push('js')

