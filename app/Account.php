<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id', 'total_summ'
    ];

    public function spendings()
    {
        return $this->hasMany('App\Spending');
    }

    public function incomings()
    {
        return $this->hasMany('App\Incomings');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function myContacts()
    {
        return $this->belongsToMany('App\Account', 'contacts', 'account_id', 'contact_id');
    }

    public function inContacts()
    {
        return $this->belongsToMany('App\Account', 'contacts', 'contact_id', 'account_id');
    }

    public function contacts()
    {
        return $this->myContacts()->wherePivot('accept',1)->with('user')->get()->merge($this->inContacts()->wherePivot('accept',1)->with('user')->get());
    }

    public function requestsMe()
    {
        return $this->myContacts()->wherePivot('accept',0)->with('user')->get();
    }

    public function requestsToMe()
    {
        return $this->inContacts()->wherePivot('accept',0)->with('user')->get();
    }
}
