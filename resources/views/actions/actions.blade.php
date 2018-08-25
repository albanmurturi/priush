@extends('adminlte::page')

@section('title', 'Last month Actions - Daily performance')

@section('content_header')
    <h1> Last month Actions - Daily performance

  </h1>
@stop

@section('content')
  

  <div class="blog-main" style="min-height:100%">

      @if($notNull)
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Last month daily performance</h3>
        <a class="btn btn-primary" href="{{ url('/actions/create')}}" style="float:right;">
          <i class="glyphicon glyphicon-plus"></i>
        </a>
      </div>

      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-bordered">
          <tbody>
            <tr>

              <th>
                Dt.
              </th>
            <!-- @foreach($acts as $act)
              <th class="vertical-text" style="width:5px">
                  <a href="<?php echo url('/acts/' . $act['id']) ?>" title="{{$act['name']}}" >{{ substr($act['name'], 0, 1) }}</a> 
              </th>
            @endforeach -->

            <th colspan="2">Progress</th>
          </tr>

            @foreach($lastMonthActions as $lastMonthAction)
            <tr>

            

              <td ><a href="{{url('action/?date=' . $lastMonthAction['date'])}}">{{date('d-m-Y',strtotime($lastMonthAction['date']))}} </a></td>

            
              <td style="width: 200px">
                <div class="progress progress-xs">
                      <div class="progress-bar {{$lastMonthAction['color']}}" style="width: {{$lastMonthAction['done'] . '%'}}"></div>
                </div>
              </td>
              
              <!-- @foreach($lastMonthAction[0] as $aod)
                <td>
                  <?php 
                    echo $aod;
                  ?>  
                </td>
              @endforeach -->
              <td class="text-center" style="width: 50px"><span class="badge {{$lastMonthAction['color']}}">{{$lastMonthAction['done'] . '%'}}</span></td>
              
            </tr>
           @endforeach
            
          </tbody>
        </table>

  
  <hr>
  <h1><a href="#" >Graphic of last month daily performance</a></h1>

  <div id="myfirstchart" style="height: 250px;"></div>

  @endif

  @include('layouts/error')

  
</div>

@stop

@section('css')

    <style type="text/css">
      .vertical-text {
            transform: rotate(-90deg);
          }

      td {
        padding: 1px !important;
      }    
    </style>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('js')

@if($notNull)
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script type="text/javascript">
    new Morris.Line({
      // ID of the element in which to draw the chart.
      element: 'myfirstchart',
      // Chart data records -- each entry in this array corresponds to a point on
      // the chart.
      data: [
        <?php 


        foreach ($lastMonthActions as $lastMonthAction): 

          echo "{ year: '" . $lastMonthAction['date'] . "', value: ". $lastMonthAction['done'] . "}," ;

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

