<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SomeMethodsController extends Controller
{
        public static function getColorClassName($value){
        switch ($value) {
          case ($value>79) :
              $color = 'bg-green';
              break;
          case ($value>59):
              $color = 'bg-blue';
              break;
          case ($value>39):
              $color = 'bg-aqua';
              break;
          case ($value>19):
              $color = 'bg-yellow';
              break;
          case null:
              $color = 'bg-red';
              break;

          default:
              $color = 'bg-red';
        }
        if($value == 0){
            $color = 'bg-red';
        }

        return $color;        

    }
}
