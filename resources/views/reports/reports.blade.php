@extends('adminlte::page')

@section('title', 'All Reports')

@section('content_header')
    <h1> All Reports 

  </h1>
@stop

@section('content')
  

<div class="blog-main" style="min-height:100%">
    
  <div> 

    <h4>
      Reports by month
    </h4>
    <ul class="list-inline">
      @foreach($actionsByMonths as $actionsByMonth)
      <li>
        <a href="<?php echo url('/reports?month=' . $actionsByMonth['month'] . '&year=' . $actionsByMonth['year'] ) ?>">
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
          <a href="<?php echo url('/reports?year=' . $actionsByYear['year'] ) ?>">
          {{$actionsByYear['year']}} 
          </a>
        </li>
      @endforeach
    </ul>
  </div>
  
  <div class="box">

  @if(count($filteredActions) != 0)



    <div class="box-body">
        <div class="info-box {{$calculatedData['color']}}">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Përqindja totale e realizimit sipas filterit: </span>
              <span class="info-box-number"> {{ $calculatedData['filter'] }} </span>

              <div class="progress">
                <div class="progress-bar" style="width: {{ $calculatedData['average_percentage'] .'%' }}"></div>
              </div>
              <span class="progress-description">
                    {{ $calculatedData['average_percentage'] .'%' }} janë realizuar prioritetet
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
    <div>       

    </div>

      <h2>Graphic at {{ $calculatedData['filter'] }} daily performance</h2>
      <div id="myfirstchart" style="height: 250px;"></div>

      <hr>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Table</h3>
        </div>
    </div>

        <table class="table table-striped" ">
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

            <th  style="width: 40px">Progress</th>
          </tr>

            @foreach($filteredActions as $filteredAction)
            <tr>

              <td>{{$filteredAction['date']}}</td>
              
              <!-- @foreach($filteredAction[0] as $aod)
                <td>
                  <?php 
                    echo $aod;
                  ?>  
                </td>
              @endforeach -->
              <td><span class="badge {{$filteredAction['color']}}">{{$filteredAction['done'] . '%'}}</span></td>
            </tr>

           @endforeach

            <tr>
              <th>
                Mesatarisht te realizuara
              </th>
              <th>
                <span class="badge {{$calculatedData['color'] }}">
                  {{$calculatedData['average_percentage'] .'%'}}
                </span>
              </th>
            </tr>
            
          </tbody>
        </table>

      @endif

      </div>
      </div>

      @include('layouts/error')
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">

    <style type="text/css">
      .vertical-text {
            transform: rotate(-90deg);
          }
    </style>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@stop

@section('js')

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


        foreach ($filteredActions as $filteredAction): 

          echo "{ year: '" . $filteredAction['date'] . "', value: ". $filteredAction['done'] . "}," ;

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


@stop

@push('css')

@push('js')

