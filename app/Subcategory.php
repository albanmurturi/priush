<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{   
	use SoftDeletes;

    public function priority(){
    	return $this->belongsTo(Priority::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function acts(){
    	return $this->hasMany(Act::class);
    }

	protected static function boot() {
    	parent::boot();

    	static::deleting(function($subcategory) {
        	$subcategory->acts()->each(function ($item) {
                $item->delete();
            });
    	});
	}
}
