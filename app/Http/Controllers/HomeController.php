<?php

namespace App\Http\Controllers;

use App\Ballance;
use App\BallanceType;
use App\Transfer;
use Auth;
use App\Spending;
use App\Incoming;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Helpers\MonthHelper;

class HomeController extends Controller
{


    public $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $acc_id = auth()->user()->account->id;
        $currentMonth = (int)date('m');
        $currentYear = (int)date('Y');

        $prevMonth = $currentMonth - 1;
        $prevYear = $currentYear;
        if($prevMonth <= 0) {
            $prevMonth = 12;
            $prevYear = $prevYear - 1;
        }

        $ball_arr = Ballance::where('account_id',$acc_id)
            ->where('month',$currentMonth)
            ->where('year',$currentYear)
            ->with('ballance_type')
            ->get();

        $prev_ball_arr = Ballance::where('account_id',$acc_id)
            ->where('month',$prevMonth)
            ->where('year',$prevYear)
            ->with('ballance_type')
            ->get();


        $spend_chart_data = Spending::where('account_id', $acc_id)->whereRaw('MONTH(created_at) = ?',[$currentMonth])
            ->with('category')
            ->groupBy('category_id')
            ->selectRaw('*, sum(total_price) as sum')
            ->get();

            //
        $ball_types = BallanceType::where('account_id',$acc_id)->where('can_transfer',1)->get();


        $shareBall = Ballance::where('month',$currentMonth)
            ->where('year',$currentYear)
            ->whereHas('ballance_type.shareContacts',function($q){
                $q->where('account_id',auth()->user()->account->id);
            })->get();
        $prev_shareBall = Ballance::where('month',$prevMonth)
            ->where('year',$prevYear)
            ->whereHas('ballance_type.shareContacts',function($q){
                $q->where('account_id',auth()->user()->account->id);
            })->get();


        return view('home',['ball_arr' => $ball_arr,'prev_ball_arr'=>$prev_ball_arr,'spend_arr'=>$spend_chart_data,'ball_types'=>$ball_types,'shareBall'=>$shareBall,'prev_shareBall'=>$prev_shareBall]);
    }

    public function allOps($id)
    {
        $acc_id = auth()->user()->account->id;

        $incs   = Incoming::where('account_id',$acc_id)->where('ballance_type_id',$id)->get();
        $spends = Spending::where('account_id',$acc_id)->where('ballance_type_id',$id)->get();
        $trans  = Transfer::where('account_id',$acc_id)->where('from_ballance_type_id',$id)->orWhere('to_ballance_type_id',$id)->with('from_ball.account.user')->get();

        $ballIds = Ballance::whereHas('ballance_type.shareContacts',function($q){
            $q->where('account_id',auth()->user()->account->id);
        })->with('ballance_type')->get();


        if(!$ballIds->isEmpty()){

            $incs = collect();
            $spends = collect();
            $trans = collect();

            foreach($ballIds as $btype) {
                $incs_arr   = Incoming::where('ballance_type_id', $btype->ballance_type->id)->get();
                $spends_arr = Spending::where('ballance_type_id', $btype->ballance_type->id)->get();
                $trans_arr  = Transfer::where('to_ballance_type_id', $btype->ballance_type->id)->with('from_ball.account.user')->get();

                if(!$incs_arr->isEmpty())
                    foreach ($incs_arr as $inc)
                        $incs->push($inc);
                if(!$spends_arr->isEmpty())
                    foreach ($spends_arr as $spend)
                        $spends->push($spend);
                if(!$trans_arr->isEmpty())
                    foreach ($trans_arr as $transf)
                        $trans->push($transf);
            }
        }



        $allItems = collect();

        if(!$incs->isEmpty())
            foreach ($incs as $inc)
                $allItems->push($inc);
        if(!$spends->isEmpty())
            foreach ($spends as $spend)
                $allItems->push($spend);
        if(!$trans->isEmpty())
            foreach ($trans as $transf)
                $allItems->push($transf);
        $full_arr = $allItems->sortByDesc('created_at');

        //dd($full_arr);

        return view('allops',['data'=>$full_arr]);
    }
}
