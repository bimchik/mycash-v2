<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'slug', 'section', 'account_id', 'commun_bill'
    ];

    public function spendings()
    {
        return $this->hasMany('App\Spending');
    }

    public function incomings()
    {
        return $this->hasMany('App\Incomings');
    }
}
