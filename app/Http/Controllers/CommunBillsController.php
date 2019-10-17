<?php

namespace App\Http\Controllers;

use App\Category;
use App\CommunBill;
use App\CommunField;
use App\CommunBillItem;
use Illuminate\Http\Request;
use App\Spending;
use App\Account;
use Carbon\Carbon;
use Str;

class CommunBillsController extends Controller
{
    private $data;
    public function index()
    {
        $acc_id = auth()->user()->account->id;
        $bills = CommunBill::orderBy('created_at','desc')->where('account_id',$acc_id)->get();

        return view('commun.index',['bills'=>$bills]);
    }

    public function currMonthBill()
    {
        $acc_id = auth()->user()->account->id;

        /*$months = array(1 => 'Январь', 2 => 'Февраль', 3 => 'Март',	4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');

        $now = Carbon::now();
        $currMonth = $now->month;
        $currYear = $now->year;

        $prevMonth = $currMonth - 1;
        if($prevMonth == '0') $prevMonth = '12';
        if($prevMonth == '12') $currYear = $currYear - 1;

        $nextMonth = $currMonth + 1;
        if($nextMonth == '13') $nextMonth = '1';
        if($nextMonth == '1') $currYear = $currYear + 1;


        $monthName = $months[$prevMonth];*/

        $bill = CommunBill::where('account_id',$acc_id)->whereRaw('MONTH(created_at) = ?',[$prevMonth])->whereRaw('YEAR(created_at) = ?',[$currYear])->with('billItems.field')->first();

        $prev = true;


        if($bill !== null && $bill->status_pay == 1){
            $bill = CommunBill::where('account_id',$acc_id)->whereRaw('MONTH(created_at) = ?',[$currMonth])->whereRaw('YEAR(created_at) = ?',[$currYear])->with('billItems.field')->first();
            $monthName = $months[$currMonth];
            $prev = false;
        }


        if($prev == true){
            $month = $prevMonth;
        } else {
            $month = $currMonth;
        }


        if($bill !== null){
            $this->data = $bill;

            $fields = CommunField::where('account_id',$acc_id)
                        ->whereNotIn('id',function($query){
                            $query->select('commun_field_id')
                            ->from('commun_bill_items')
                            ->where('commun_bill_id',$this->data->id);
                        })
                        ->get();

            $t_sum = "0.00";

            foreach ($fields as $f){

                if($f->calcBy == "fixed") {
                    $i_sum = $f->tariff_price;
                } else if($f->calcBy == "numPeople"){
                    $i_sum = $f->tariff_price * $f->people_count;
                } else if($f->calcBy == "numSpace"){
                    $i_sum = $f->tariff_price * $f->space_count;
                }

                $t_sum += $i_sum;

            }

            $tot_sum = round($t_sum + $this->data->total_sum,2);

            return view('commun.single',['data'=>$this->data,'total_sum'=>$tot_sum,'fields'=>$fields,'month'=>$month,'monthName'=>$monthName,'currYear'=>$currYear]);
        } else {
            $this->data = CommunField::where('account_id',$acc_id)->get();

            return view('commun.add',['data'=>$this->data,'month'=>$month,'monthName'=>$monthName,'currYear'=>$currYear]);
        }

    }

    public function store(Request $data)
    {

        $acc_id = auth()->user()->account->id;


        /**** Check if bill is exists by month-year, else create new bill ****/
        $now = Carbon::now();

        $currMonth = $now->month;
        $currYear = $now->year;

        $months = array('01' => 'Январь', '02' => 'Февраль', '03' => 'Март',	'04' => 'Апрель',
            '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август',
            '09' => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');

        if($data->billId !== null) {

            $bill = CommunBill::whereId($data->billId)->where('account_id', $acc_id)->with('billItems.field')->first();

        }
        else {

            $cr_data = [
                'account_id' => $acc_id,
                'status_save' => 0,
                'status_pay' => 0
            ];

            if((int)$data->month !== $currMonth){
                $created_at = $now->copy()->subMonth();
                if($created_at->day == '1' && $created_at->month == $currMonth){
                    $created_at = $created_at->subDay();
                }
                $cr_data['created_at'] = $created_at;
                $mName = $created_at->format('m');
                $mName = $months[$mName];
                //dd($mName);
                $cr_data['monthName'] = $mName;
            } else {
                $mName = $now->format('m');
                $mName = $months[$mName];
                $cr_data['monthName'] = $mName;
                $cr_data['created_at'] = $now;
            }

            //dd($cr_data);

            $bill = CommunBill::create($cr_data);
        }


        /**** Store billItems ****/
        if($data->field_id !== null){

            foreach($data->field_id as $f_id){
                $b_item = CommunBillItem::where('commun_bill_id',$bill->id)->where('commun_field_id',$f_id)->first();

                $last_val = $data->input("last_val-".$f_id);
                $next_val = $data->input("next_val-".$f_id);
                $sum = $data->input("sum-".$f_id);


                if($b_item == null){
                    CommunBillItem::create([
                        'commun_bill_id' => $bill->id,
                        'commun_field_id' => $f_id,
                        'last_val' => $last_val,
                        'next_val' => $next_val,
                        'sum' => $sum,
                        'status_save' => 1,
                        'status_pay' => 0
                    ]);

                    $currVal = CommunField::whereId($f_id)->where('account_id',$acc_id)->select('current_count_value')->first();

                    if($next_val !== null && $currVal !== null && $next_val !== $currVal->current_count_value) {
                        CommunField::whereId($f_id)->where('account_id', $acc_id)->update([
                            'current_count_value' => $next_val
                        ]);
                    }

                } else {
                    $b_item->update([
                        'last_val' => $last_val,
                        'next_val' => $next_val,
                        'sum' => $sum,
                    ]);
                }
            }

        }



        if($data->for_pay) {

           foreach($data->for_pay as $pay_id){

                $itemData = ['status_pay' => 1];

                if($data->pay !== null){
                    $itemData['status_pay'] = 1;
                }

                CommunBillItem::where('commun_bill_id',$bill->id)->where('commun_field_id',$pay_id)->update($itemData);

            }

        }


        $tot_sum = '0.00';

        $payed_sum = '0.00';

        $it_sum = CommunBillItem::where('commun_bill_id',$bill->id)->select('sum')->get();

        $sumData = [];

        foreach ($it_sum as $i_sum) {
            $tot_sum += $i_sum->sum;
        }

        $sumData['total_sum'] = $tot_sum;

        $ip_sum = CommunBillItem::where('commun_bill_id',$bill->id)->where('status_pay',1)->select('sum')->get();

        foreach ($ip_sum as $i_sum) {
            $payed_sum += $i_sum->sum;
        }

        $sumData['payed_sum'] = $payed_sum;

        CommunBill::whereId($bill->id)->where('account_id',$acc_id)->update($sumData);



        if($payed_sum > 0) {

            $cat = Category::where('commun_bill', true)->select('id')->first();
            $cat_name = 'Коммунальные услуги';

            if($cat == null){
                $cat = Category::create([
                    "account_id" => $acc_id,
                    "name" => $cat_name,
                    "slug" => Str::slug($cat_name),
                    "section" => 'spendings',
                    "commun_bill" => '1'
                ]);
            }

            $spend = Spending::create([
                'account_id' => $acc_id,
                'category_id' => $cat->id,
                'loc_tag_id' => 0,
                'qty' => 1,
                'total_price' => $payed_sum,
                'commun_bill' => true,
                'bill_id' => $bill->id
            ]);

        }

        $status_pay = 0;
        $status_save = 1;

        $bItems = CommunBillItem::where('commun_bill_id',$bill->id)->get();

        foreach ($bItems as $bitem){
            if($bitem->status_pay == 0) {
                $status_pay = 0;
                break;
            } else if($bitem->status_pay == 1) {
                $status_pay = 1;
            }
        }

        CommunBill::whereId($bill->id)->where('account_id',$acc_id)->update(['status_save' => $status_save,'status_pay'=>$status_pay]);

        $to_sum = Account::where('id',$acc_id)->pluck('total_summ')->first();

        $to_sum = $to_sum - $payed_sum;

        $upd = Account::where('id',$acc_id)->update(['total_summ' => $to_sum]);

        return back();
    }

    public function bill($id)
    {
        $acc_id = auth()->user()->account->id;

        $bill = CommunBill::whereId($id)->where('account_id',$acc_id)->with('billItems.field')->first();

        $months = array('01' => 'Январь', '02' => 'Февраль', '03' => 'Март',	'04' => 'Апрель',
            '05' => 'Май', '06' => 'Июнь', '07' => 'Июль', '08' => 'Август',
            '09' => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь');

        $bMonth = $bill->created_at->format('m');
        $bYear = $bill->created_at->format('Y');

        $monthName = $months[$bMonth];

        //dd($bYear);die();
        if($bill !== null){
            $this->data = $bill;

            $fields = CommunField::where('account_id',$acc_id)
                ->whereNotIn('id',function($query){
                    $query->select('commun_field_id')
                        ->from('commun_bill_items')
                        ->where('commun_bill_id',$this->data->id);
                })
                ->get();
            $t_sum = "0.00";

            foreach ($fields as $f){

                if($f->calcBy == "fixed") {
                    $i_sum = $f->tariff_price;
                } else if($f->calcBy == "numPeople"){
                    $i_sum = $f->tariff_price * $f->people_count;
                } else if($f->calcBy == "numSpace"){
                    $i_sum = $f->tariff_price * $f->space_count;
                }

                $t_sum += $i_sum;

            }

            $tot_sum = round($t_sum + $this->data->total_sum,2);
            return view('commun.single',['data'=>$this->data,'total_sum'=>$tot_sum,'fields'=>$fields,'monthName'=>$monthName,'currYear'=>$bYear]);
        }

    }
}
