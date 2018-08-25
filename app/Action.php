<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes; 
 
class Action extends Model
{   
    use SoftDeletes;

    public function act(){
    	return $this->belongsTo(Act::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function scopeActionsGrupedByDate($query){
    	return $query->selectRaw('date date, count(*) published')
                    ->where('date', '>=', Carbon::now()->startOfMonth())
                    ->groupBy('date')
                    ->orderByRaw('min(date) desc')
                    ->get()
                    ->toArray();
    }

    public function scopeActionOnDate($query, $date){
    	return $query->where('date', $date)
                    ->get()
                    ->toArray();
    }

    public function scopeActionsByActId($query){
    	return $query->selectRaw('act_id act_id, count(*) published')
                    ->where('date', '>=', Carbon::now()->startOfMonth())
                    ->groupBy('act_id')
                    ->orderByRaw('min(act_id) asc')
                    ->get()
                    ->toArray();
    }
}
