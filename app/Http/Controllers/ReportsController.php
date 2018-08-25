<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\SomeMethodsController as SMC;

class ReportsController extends Controller
{   
    public function __construct(){

        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actionsByMonths = auth()->user()->actions()
                        ->selectRaw('year(created_at) year, monthname(created_at) month')
                        ->groupBy('year', 'month')
                        ->orderByRaw('min(created_at) desc')
                        ->get()
                        ->toArray();

        $actionsByYears = auth()->user()->actions()
                        ->selectRaw('year(created_at) year')
                        ->groupBy('year')
                        ->orderByRaw('min(created_at) desc')
                        ->get()
                        ->toArray();


        $actions = auth()->user()->actions()
                    ->selectRaw('date date, count(*) published')
                    ->groupBy('date')
                    ->orderByRaw('min(date) desc');

        if(!request('month') && !request('year') ) {
                $now = Carbon::now();
                $month = $now->format('F');
                $year = $now->year;
                $actions->whereMonth('date', Carbon::parse($month)->month)->whereYear('created_at', $year);
        } else {

            if($month = request('month')) {
                $actions->whereMonth('date', Carbon::parse($month)->month);
            } 

            if($year = request('year')) {
               $actions->whereYear('date', $year);
            }
        }

        $actions = $actions->get()->toArray();

        $acts = auth()->user()->acts()->idAndName();

        // dd($acts);


        $filteredActions = array();
        $calculatedData = array();

        if(count($acts) == 0){

           return view('/reports.reports', compact('filteredActions', 'actionsByMonths', 'actionsByYears'))->withErrors([
            'message' => 'There is no any data for those condition (filter)']);
        }


        if(count($actions) == 0){

           return view('/reports.reports', compact('filteredActions', 'actionsByMonths', 'actionsByYears'))->withErrors([
            'message' => 'There is no any data for those condition (filter)']);
        }


        $average_percentage = 0;
        foreach($actions as $action){


            $aDayActions = array();

            $aDayActions += ['date' => $action['date']];

            $actionOnDate = auth()->user()->actions()->actionOnDate($action['date']);

            $i = count($actionOnDate);
            $done = 0;

                $values = array();
            // if(isset($values)){
            //    unset($values);
            // } else {
            //     $values = array();
            // }
            foreach($actionOnDate as $aod){
                array_push($values, $aod['is_done']);
                $done += $aod['is_done'];
            }
            
            $done = intval(round($done/$i*100));

            $average_percentage += $done;

            array_push($aDayActions, $values);
            $aDayActions += ['done'  => $done];
            $aDayActions += ['color'  => SMC::getColorClassName($done)];

            unset($values);
            array_push($filteredActions, $aDayActions);
        
            unset($aDayActions);
        }

        // dd($filteredActions);

        $average_percentage = intval($average_percentage/count($actions));

        $filter = $month . ' ' . $year;

        $color = SMC::getColorClassName($average_percentage);
        


        $calculatedData += [
                                'average_percentage'  => $average_percentage,
                                'color'  => $color,
                                'filter'  => $filter
                            ];


        
        // dd($average_percentage);

        return view('reports.reports', compact('actionsByMonths', 'actionsByYears','filteredActions', 'acts', 'calculatedData'));
    }

    public function lastmonth()
    { 

        $actions = auth()->user()->actions()->actionsByActId();

        if(count($actions) == 0){

            return view('reports.lastmonth', compact('actions'))->withErrors([
                'message' => 'You did not add any actio yet']);
        }

          $lastMonthActions = array();

          foreach($actions as $action) {


                
                $actionOnId = auth()->user()->actions()
                                ->where('date', '>=', Carbon::now()->startOfMonth())
                                ->where('act_id', $action['act_id'])
                                ->get();

                $actionName = auth()->user()->acts()
                                ->where('id', $action['act_id'])
                                ->first();

                $i = count($actionOnId);
                $done = count($actionOnId->where('is_done', 1));
                
                $done = intval(round($done/$i*100));

                switch ($done) {
                  case ($done>79) :
                      $color = '#008d4c';
                      break;
                  case ($done>59):
                      $color = '#357ca5';
                      break;
                  case ($done>39):
                      $color = '#00a7d0';
                      break;
                  case ($done>19):
                      $color = '#db8b0b';
                      break;
                  case null:
                      $color = '#d33724';
                      break;

                  default:
                      $color = '#d33724';
                }
                if($done == 0){
                    $color = '#d33724';
                }
            array_push($lastMonthActions, 
                array(
                    'name' => $actionName->name,
                    'value' => $done,
                    'color' => $color
                )
            );

          }

          // dd($lastMonthActions) ;

        return view('/reports.lastmonth', compact('lastMonthActions', 'actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
