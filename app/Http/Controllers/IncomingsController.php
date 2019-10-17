<?php

namespace App\Http\Controllers;

use App\Incoming;
use App\Account;
use App\Ballance;
use App\BallanceType;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomingsController extends Controller
{
    public function index()
    {
        $acc_id = auth()->user()->account->id;
        $cats = Category::where('section','incomings')->where('account_id',$acc_id)->orWhere('account_id',null)->get()->toArray();

        $ballance_types = BallanceType::where('account_id',$acc_id)->get()->toArray();

        return view('incomings.add',['cats' => $cats,'ballance_types'=>$ballance_types]);
    }

    public function store(Request $data)
    {
        $acc_id = auth()->user()->account->id;
        $user_id = auth()->user()->id;

        if($data->date !== null){
            $date = Carbon::parse($data->date_submit);
        } else {
            $date = Carbon::now();
        }

        $day = $date->day;
        $month = $date->month;
        $year = $date->year;

        $months = array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март',	4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');

        $month_name = $months[(int)$month];

        $total_sum = $data->price;

        $ball = Ballance::where('account_id',$acc_id)->where('ballance_type_id',$data->ballance_type_id)->where('month',$month)->where('year',$year)->first();

        if($ball == null){

            $prev_month = $month - 1;

            if($prev_month <= 0) {
                $prev_month = 12;
                $year = $year - 1;
            }

            $ball = Ballance::where('account_id',$acc_id)->where('ballance_type_id',$data->ballance_type_id)->where('month',$prev_month)->where('year',$year)->first();

            if($ball == null) {

                $sum = $data->price;

            } else {
                $sum = $ball->sum + $data->price;
            }

            $ball = Ballance::create([
                'account_id' => $acc_id,
                'ballance_type_id' => $data->ballance_type_id,
                'sum' => $sum,
                'month' => $month,
                'year' => $year,
                'month_name' => $month_name
            ]);

        } else {
            $total_sum = $ball->sum + $total_sum;

            $upd = $ball->update(['sum' => $total_sum]);
        }

        $ball_next = Ballance::where('account_id',$acc_id)->get();

        foreach($ball_next as $bnext){
            if($bnext->month > $month && $bnext->year == $year){

                $bsum = $bnext->sum + $total_sum;

                Ballance::whereId($bnext->id)->where('account_id',$acc_id)->update(['sum'=>$bsum]);
            } else if($bnext->month < $month && $bnext->year > $year){
                $bsum = $bnext->sum + $total_sum;
                Ballance::whereId($bnext->id)->where('account_id',$acc_id)->update(['sum'=>$bsum]);
            }
        }


        $inc = Incoming::create([
            'account_id'  => $acc_id,
            'category_id' => $data->cat,
            'ballance_type_id' => $data->ballance_type_id,
            'ballance_id' => $ball->id,
            'day'=>$day,
            'operation_type'=>'incoming',
            'price' => $data->price
        ]);

        return redirect('/home');

    }

    public function list($id = null)
    {
        $acc_id = auth()->user()->account->id;
        $inc = Incoming::where('account_id',$acc_id);
        if($id) $inc = $inc->where('category_id',$id);
        $inc = $inc->with('category')->orderBy('created_at', 'desc')->get();

        return view('incomings.index',['data' => $inc]);
    }

    public function typelist($id)
    {
        $acc_id = auth()->user()->account->id;
        $inc = Incoming::where('account_id',$acc_id)->where('ballance_type_id',$id)->with('category')->orderBy('created_at', 'desc')->get();

        return view('incomings.index',['data' => $inc]);
    }
}
