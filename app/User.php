<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function priorities(){
        return $this->hasMany(Priority::class);
    }

    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    public function acts(){
        return $this->hasMany(Act::class);
    }

    public function actions(){
        return $this->hasMany(Action::class);
    }

    public function addPriority(Priority $priority){
        // dd($priority);
        $this->priorities()->save($priority);
    }

    public function addSubcategory(Subcategory $priority){
        // dd($priority);
        $this->subcategories()->save($priority);
    }

    public function addAct(Act $priority){
        // dd($priority);
        $this->acts()->save($priority);
    }
}