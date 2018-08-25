<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Act extends Model
{     
    use SoftDeletes;

    public function subcategory(){
    	return $this->belongsTo(Subcategory::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function actions(){
    	return $this->hasMany(Action::class);
    }

    public function scopeIdAndName($query){
    	return $query->selectRaw('id, name')
                    ->get()
                    ->toArray();
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($act) {
            $act->actions()->each(function ($item) {
                $item->delete();
            });
        });
    }
}
