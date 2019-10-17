<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name','city_id', 'address','lng','lnt'
    ];

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
