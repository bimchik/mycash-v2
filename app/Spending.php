<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    protected $fillable = [
        'account_id', 'category_id', 'loc_tag_id', 'qty', 'total_price','commun_bill','bill_id','ballance_type_id','ballance_id','day','operation_type','tag_id'
    ];

    public function loctag()
    {
        return $this->hasOne('App\LocTag','id', 'loc_tag_id');
    }

    public function tag()
    {
        return $this->hasOne('App\Tag','id', 'tag_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function bill()
    {
        return $this->hasOne('App\CommunBill');
    }

}
