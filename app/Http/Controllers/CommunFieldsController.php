<?php

namespace App\Http\Controllers;

use App\CommunField;
use Illuminate\Http\Request;
use App\CommunBill;

class CommunFieldsController extends Controller
{
    public function index()
    {
        $acc_id = auth()->user()->account->id;

        $fields = CommunField::where('account_id', $acc_id)->get();

        return view('commun.fields',['fields'=>$fields]);
    }

    public function store(Request $data)
    {
        $acc_id = auth()->user()->account->id;

        if($data->for_prev_month !== null && $data->for_prev_month == "1"){

            $bill = CommunBill::where('account_id',$acc_id)->orderBy('created_at','desc')->first();

            if($bill !== null && $bill->status_pay == 1) {
                $bill->update([
                    'status_pay' => 0
                ]);
            }

        }

        CommunField::create([
            'account_id' => $acc_id,
            'name' => $data->name,
            'calcBy' => $data->calcBy,
            'current_count_value' => $data->current_count_value,
            'tariff_price' => $data->tariff_price,
            'people_count' => $data->people_count,
            'space_count' => $data->space_count
        ]);

        return redirect('commun/fields');
    }

    public function delete($id)
    {
        CommunField::find($id)->delete($id);


        return response()->json([

            'success' => 'Record deleted successfully!'

        ]);
    }
}
