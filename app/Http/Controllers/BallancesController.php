<?php

namespace App\Http\Controllers;

use App\Ballance;
use Illuminate\Http\Request;

class BallancesController extends Controller
{
    public function index()
    {
        $acc_id = auth()->user()->account->id;

        $ballances = Ballance::where('account_id',$acc_id)->with('ballance_type')->orderBy('created_at','desc')->get();

        $users = Ballance::whereHas('ballance_type', function($q){
            //$q->where('created_at', '>=', '2015-01-01 00:00:00');
            dd($q->toArray());
        })->get();

        return view('archive.ballances',['ballances'=>$ballances]);
    }
}
