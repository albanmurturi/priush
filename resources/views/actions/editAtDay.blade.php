@extends('adminlte::page')

@section('title', 'Edit Actions')

@section('content_header')
    <h1> Edit Actions on date: {{$actions[0]['date']}}

	</h1>
@stop

@section('content')
	

	<div class="blog-main" style="min-height:100%">

	<div class="blog-post">
    @if(count($actions) != 0)
		<form method="POST" action="{{url('/actions/update?date=' . $actions[0]['date'] )}}">

      @method('PUT') 

				{{ csrf_field() }} 
				@foreach($actions as $action)

					<div class="form-group">
						<div class="radio">
						<label> <strong> {{$action['name']}}: </strong></label> <br>
                    @if($action['is_done'])
                        <label>
                            <input type="radio" name="{{$action['id']}}" id="{{$action['id']}}" value="1" checked="checked">
                                Done
                        </label>
                        <label>
                            <input type="radio" name="{{$action['id']}}" id="{{$action['id']}}" value="0">
                                Didn't Done
                        </label>
                      </div>
                    @else
                    		<label>
                      			<input type="radio" name="{{$action['id']}}" id="{{$action['id']}}" value="1">
                      					Done
                    		</label>
                    		<label>
                      			<input type="radio" name="{{$action['id']}}" id="{{$action['id']}}" value="0" checked="checked">
                      					Didn't Done
                    		</label>
                  		</div>
                    @endif
					</div>

				@endforeach


				 
				<div class="form-group" >
				 	<button type="submit" class="btn btn-info">Save</button>
			    </div>				
			</form>
      @endif

			@include('layouts/error')
	</div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop

@push('css')

@push('js')