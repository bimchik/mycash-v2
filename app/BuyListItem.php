<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyListItem extends Model
{
    protected $fillable = [
        'buylist_id','tag_id','payed_sum','status','qty','location_id','loc_tag_id'
    ];

    public function tag()
    {
        return $this->hasOne('App\Tag', 'id', 'tag_id');
    }

    public function location()
    {
        return $this->hasOne('App\Location', 'id', 'location_id');
    }

    public function loctag()
    {
        return $this->hasOne('App\LocTag', 'id', 'loctag_id');
    }
}
