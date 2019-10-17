<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'account_id', 'contact_id'
    ];

    public function contact1()
    {
        return $this->belongsTo('App\Account');
    }

    public function contact2()
    {
        return $this->belongsTo('App\Account');
    }

}
