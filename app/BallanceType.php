<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BallanceType extends Model
{
    protected $fillable = [
        'account_id','name','slug','can_transfer','can_minus', 'share', 'contact_ids'
    ];
    protected $casts = [
        'contact_ids' => 'array'
    ];

    public function ballances()
    {
        return $this->hasMany('App\Ballance');
    }

    public function shareContacts()
    {
        return $this->belongsToMany('App\Account','ballance_account','ballance_id', 'account_id');
    }
}
