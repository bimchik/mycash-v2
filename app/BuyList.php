<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyList extends Model
{
    protected $fillable = [
        'account_id','total_sum','confirmed','saved'
    ];

    public function listItems()
    {
        return $this->hasMany('App\BuyListItem', 'buylist_id','id');
    }
}
