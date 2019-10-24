<?php

namespace App\Http\Controllers;

use App\BallanceType;
use Str;
use App\Ballance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BallanceTypesController extends Controller
{
    private $acc_id;
    private $account;
    private $ballTypeInterface;

    public function __construct(BallanceTypeInterface $ballTypeInterface)
    {
        $this->ballTypeInterface = $ballTypeInterface;
        $this->middleware(function ($request, $next) {
            $this->account = Auth::user()->account;

            return $next($request);
        });
    }

    public function index()
    {
        $ballance_types = $this->ballTypeInterface->getBallanceTypesWithContacts($this->account);

        $contacts = $this->account->contacts();

        return view('settings.ballance.types',compact('ballance_types','contacts'));
    }

    public function store(Request $data)
    {
        //dd($data);
        if($data->name !== null){

            $type = BallanceType::where('account_id',$this->acc_id)->where('name',$data->name)->first();

            if($type === null){

                $can_trans = $data->can_transfer;

                if($data->can_transfer === null){
                    $can_trans = 0;
                }

                $can_minus = $data->can_minus;

                if($data->can_minus === null){
                    $can_minus = 0;
                }

                $type = BallanceType::create([
                    'account_id'=>$this->acc_id,
                    'name'=>$data->name,
                    'slug'=>Str::slug($data->name),
                    'can_transfer'=>$can_trans,
                    'can_minus'=>$can_minus
                ]);

                $type->shareContacts()->attach($data->contacts);

                $date = Carbon::now();

                $month = $date->month;
                $year = $date->year;

                $months = array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март',	4 => 'Апрель',
                    5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
                    9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');

                $month_name = $months[(int)$month];


                $ball = Ballance::create([
                    'account_id'=>$this->acc_id,
                    'ballance_type_id'=>$type->id,
                    'sum'=>'0.00',
                    'month_name'=>$month_name,
                    'month'=>$month,
                    'year'=>$year
                ]);

            }

        }

        return redirect()->back();
    }
}
