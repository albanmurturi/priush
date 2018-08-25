@extends('adminlte::page')

@if($pass_key)
	@section('title', 'Act: ' . $act->name)

	@section('content_header')    
		<h1>Aact: <a href="#" >{{ $act->name}}</a>
			<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#exampleModal1" >
	        	<i class="glyphicon glyphicon-edit"></i> Edit
	    	</a>
			<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal" >
		    	<i class="glyphicon glyphicon-trash"></i> Delete
	    	</a> 
		</h1>
	@stop
@endif	

@section('content')

<div> 
	@if (Session::has('success'))
	        <div class="alert alert-success">{!! Session::get('success') !!}</div>
	    @endif
	    @if (Session::has('failure'))
	        <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
	@endif

@if($pass_key)	
    <h4>
      Reports by month
    </h4>
    <ul class="list-inline">
      @foreach($actionsByMonths as $actionsByMonth)
      <li>
        <a href="<?php echo url('/acts/' . $act->id . '?month=' . $actionsByMonth['month'] . '&year=' . $actionsByMonth['year'] ) ?>">
         {{$actionsByMonth['month'] . ' ' . $actionsByMonth['year']}} 
        </a>
      </li>
      @endforeach
    </ul>
      
    <h4>
      Reports by year
    </h4>

    <ul class="list-inline">
      @foreach($actionsByYears as $actionsByYear)
        <li>
          <a href="<?php echo url('/acts/'.$act->id . '?year=' . $actionsByYear['year'] ) ?>">
          {{$actionsByYear['year']}} 
          </a>
        </li>
      @endforeach
    </ul>
  </div>

  @if(count($actions) != 0)

    <div class="box-body">
	    <div class="info-box {{$calculatedData['color']}}">
		    <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

		    <div class="info-box-content">
		      <span class="info-box-text">{{ $act->name . ' - at - ' . $calculatedData['filter'] }}</span>
		      <span class="info-box-number"> {{ $calculatedData['total'] . ' from ' . $calculatedData['all'] }} </span>

		      <div class="progress">
		        <div class="progress-bar" style="width: {{ $calculatedData['average_percentage'] .'%' }}"></div>
		      </div>
		      <span class="progress-description">
		            {{ $calculatedData['average_percentage'] .'%' }} është realizuar ky veprim
		          </span>
		    </div>
		    <!-- /.info-box-content -->
		</div> 
		<br>
		<br>
		<h4> Chart with date at {{$calculatedData['filter']}} of {{$act->name}} act. </h4>
		<div id="myfirstchart" style="height: 250px;"></div>    

    </div>

	@endif


			@include('layouts/error')

	<form action="{{url('/acts/' . $act->id)}}" method="POST" class="remove-record-model">
	@method('delete')	

	{{ csrf_field() }}

	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Security step
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    	</h5>
	      </div>
	      <div class="modal-body">
	        Are you sure you want to delete priority: {{$act->name}} 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-danger">Delete</button>
	      </div>
	    </div>
	  </div>
</div>


</form>

<form action="{{url('/acts/' . $act->id)}}" method="POST" class="remove-record-model">
	@method('PUT')	

	{{ csrf_field() }}

	<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h3 class="modal-title" id="exampleModalLabel">Edit act: {{$act->name}} 
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	        </h3>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
				<label for="Name">Name:</label>
				<input type="text" class="form-control" name="name" id="name" value="{{$act->name}}" >
			</div> 
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-info">Edit</button>
	      </div>
	    </div>
	  </div>
</div>
</form>
@endif		
@stop


@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <link rel="stylesheet" href="{{asset('/css/crud.css')}}">
@stop

@section('js')


<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

@if($pass_key)
	<script type="text/javascript">
		new Morris.Line({
		  // ID of the element in which to draw the chart.
		  element: 'myfirstchart',
		  // Chart data records -- each entry in this array corresponds to a point on
		  // the chart.
		  data: [
		  	<?php 

		  	$done = 0;

		  	foreach ($actions as $action): 

		  		if($action['is_done'] == 1 ){$done++;}

		  		echo "{ year: '" . $action['date'] . "', value: ". round(($done/$calculatedData['all'])*100) . "}," ;

		  	?>
		  		
		  	<?php endforeach ?>
		    
		  ],
		  // The name of the data record attribute that contains x-values.
		  xkey: 'year',
		  // A list of names of data record attributes that contain y-values.
		  ykeys: ['value'],
		  // Labels for the ykeys -- will be displayed when you hover over the
		  // chart.
		  labels: ['Value']
		});
	</script>
@endif

@stop

@push('css')

@push('js')