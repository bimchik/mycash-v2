<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transfer;
use App\Ballance;
use Carbon\Carbon;

class TransfersController extends Controller
{
    public function index()
    {
        $acc_id = auth()->user()->account->id;
        $transfers = Transfer::where('account_id',$acc_id)->with('from_ball','to_ball')->get();

        return view('archive.transfers',['transfers'=>$transfers]);
    }

    public function transfer(Request $data)
    {
        $acc_id = auth()->user()->account->id;

        $to     = (int)$data->to_ball_type;
        $from   = (int)$data->from_ball_type;
        $sum    = $data->trans_sum;

        $now    = Carbon::now();

        $month  = $now->month;
        $year   = $now->year;

        $prevMonth = $month - 1;
        $prevYear = $year;
        if($prevMonth == 0){
            $prevMonth = 12;
            $prevYear = $prevYear - 1;
        }

        $to_ball = Ballance::where('account_id',$acc_id)->where('month',$month)->where('year',$year)->where('ballance_type_id',$to)->first();

        if($to_ball == null){
            $to_ball = Ballance::where('account_id',$acc_id)->where('month',$prevMonth)->where('year',$prevYear)->where('ballance_type_id',$to)->first();
        }

        $from_ball = Ballance::where('account_id',$acc_id)->where('month',$month)->where('year',$year)->where('ballance_type_id',$from)->first();

        if($from_ball == null){
            $from_ball = Ballance::where('account_id',$acc_id)->where('month',$prevMonth)->where('year',$prevYear)->where('ballance_type_id',$from)->first();
        }

        $to_next_sum = $to_ball->sum + $sum;
        $from_next_sum = $from_ball->sum - $sum;

        $to_ball->update(['sum'=>$to_next_sum]);
        $from_ball->update(['sum'=>$from_next_sum]);

        Transfer::create([
            'account_id'=>$acc_id,
            'from_ballance_id'=>$from_ball->id,
            'from_ballance_type_id'=>$from,
            'to_ballance_id'=>$to_ball->id,
            'to_ballance_type_id'=>$to,
            'operation_type'=>'transfer',
            'sum'=>$sum
        ]);

        return redirect()->back();
    }
}
