<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
	use SoftDeletes;

	protected $table = 'priorities';
	
	public function subcategories(){
		return $this->hasMany(Subcategory::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	protected static function boot() {
    	parent::boot();

    	static::deleting(function($priority) {
    		$priority->subcategories()->each(function ($item) {
		        $item->delete();
		    });

    	});
	}
}
