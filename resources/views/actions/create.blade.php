@extends('adminlte::page')

@section('title', 'Add Actions')

@section('content_header')
    <h1> Add Actions

	</h1>
@stop

@section('content')
	

	<div class="blog-main" style="min-height:100%">

	<div class="blog-post">
      @if(count($acts) != 0)
			<form method="POST" action="<?php echo url('/actions') ?>">

				{{ csrf_field() }} 
				
				@foreach($acts as $act)

					<div class="form-group">
						<div class="radio">
						<label> <strong> {{$act->name}}: </strong></label> <br>
                    		<label>
                      			<input type="radio" name="{{$act->id}}" id="{{$act->id}}" value="1"  checked="checked">
                      					Done
                    		</label>
                    		<label>
                      			<input type="radio" name="{{$act->id}}" id="{{$act->id}}" value="0">
                      					Didn't Done
                    		</label>
                  		</div>
					</div>

				@endforeach
			  <div class="form-group row"> <!-- Date input -->
            <div class="col-lg-3 col-md-4 col-sm-8 col-xs-12">
		            <label class="control-label" for="date">At</label>
                <input class="form-control" id="date" name="date" placeholder="yyyy-mm-dd" type="text"/>
            </div>
		    </div>

				<div class="form-group" >
				 	<button type="submit" class="btn btn-primary">Publish</button>
			    </div>				
			</form>
      @endif

			@include('layouts/error')
	</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<!--  jQuery -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
    $(document).ready(function(){
      var date_input=$('input[name="date"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',
            changeMonth: true,
        changeYear: true,
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
</script>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
            changeMonth: true,
            changeYear: true,
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>
@stop

@push('css')

@push('js')