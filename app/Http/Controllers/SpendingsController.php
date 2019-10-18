<?php

namespace App\Http\Controllers;

use Auth;
use App\Category;
use App\Spending;
use App\Account;
use App\Tag;
use App\LocTag;
use App\Location;
use App\Ballance;
use App\BallanceType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Repositories\Interfaces\SpendingsInterface;

class SpendingsController extends Controller
{
    private $acc_id;
    private $account;
    private $spendingsInterface;

    public function __construct(SpendingsInterface $spendingsInterface)
    {
        $this->spendingsInterface = $spendingsInterface;

        $this->middleware(function ($request, $next) {
            $this->account = Auth::user()->account;

            return $next($request);
        });
    }

    public function index()
    {

        $cats = Category::where('section','spendings')->where('account_id',$this->acc_id)->orWhere('account_id',null)->get()->toArray();

        $ballance_types = $this->spendingsInterface->getBallanceTypesArrByAccount($this->account);

        return view('spendings.add',compact('cats','ballance_types'));
    }

    public function store(Request $data)
    {
        $unit_price = $data->total_price / $data->qty;

        if($data->loc_tag_id !== null){
            $loc_tag_id = $data->loc_tag_id;
        } else {

            if ($data->tag_id == null && $data->tag !== null) {

                $tag = Tag::where('name', $data->tag)->first();

                if ($tag == null) {

                    $tag = Tag::create([
                        'name' => $data->tag,
                        'unit' => $data->tag_unit
                    ]);

                }

                $data->tag_id = $tag->id;

            }

            if ($data->location_id == null && $data->location !== null) {

                $location = Location::where('name', $data->location)->where('address', $data->address)->first();

                if ($location == null) {

                    $location = Location::create([
                        'name' => $data->location,
                        'address' => $data->address
                    ]);

                }

                $tag->locations()->attach($location);

                $loc_tag_id = $tag->locations()->withPivot('id')->wherePivot('location_id', $location->id)->first()->pivot->id;

            }

            if ($data->location_id !== null && $data->tag_id !== null) {
                $loc_tag = LocTag::where('location_id', $data->location_id)->where('tag_id', $data->tag_id)->select('id')->first();

                $loc_tag_id = $loc_tag['id'];
            }

        }

        $loc_tag_price = LocTag::whereId($loc_tag_id)->update([
            'unit_price' => $unit_price
        ]);

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

        $total_sum = $data->total_price;

        $ball_type = BallanceType::whereId($data->ballance_type_id)->where('account_id',$acc_id)->first();

        $ball = Ballance::where('account_id',$acc_id)->where('ballance_type_id',$data->ballance_type_id)->where('month',$month)->where('year',$year)->with('ballance_type')->first();

        if($ball == null){

            $prev_month = $month - 1;

            if($prev_month <= 0) {
                $prev_month = 12;
                $year = $year - 1;
            }

            $ball = Ballance::where('account_id',$acc_id)->where('ballance_type_id',$data->ballance_type_id)->where('month',$prev_month)->where('year',$year)->with('ballance_type')->first();

            $sum = $ball->sum - $data->price;


            if($ball->ballance_type->can_minus == 0 && $sum < 0) {
                Session::flash('message','Buy price > Ballance sum!');
                Session::flash('alert-class','danger');

                return redirect('/home');
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
            $total_sum = $ball->sum - $total_sum;


            if($ball->ballance_type->can_minus == 0 && $total_sum < 0) {
                Session::flash('message','Buy price > Ballance sum!');
                Session::flash('alert-class','danger');

                return redirect('/home');
            }

            $upd = $ball->update(['sum' => $total_sum]);
        }

        $spend = Spending::create([
            'account_id'  => $acc_id,
            'category_id' => $data->cat,
            'loc_tag_id'  => $loc_tag_id,
            'qty'         => $data->qty,
            'total_price' => $data->total_price,
            'ballance_type_id' => $data->ballance_type_id,
            'ballance_id' => $ball->id,
            'day'=>$day,
            'operation_type'=>'spending',
            'commun_bill' => false
        ]);

        Session::flash('message','Покупка учтена');
        Session::flash('alert-class','success');

        return redirect('/home');

    }

    private function createLocTag(){

    }

    function fetch(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');

            $data = Tag::with('locations')
                ->where('name', 'LIKE', "%{$query}%")
                ->get();

            if(!$data->isEmpty()) {

                $output = '<ul class="list-group" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $output .= '
                        <li class="tag list-group-item" el-unit="' . $row->unit . '" tag-id="' . $row->id . '"><a>' . $row->name . '</a></li>
                    ';

                    if ($row->locations) {

                        foreach ($row->locations as $loc) {

                            $output .= '
                                <li class="tag list-group-item" el-unit="' . $row->unit . '" tag-id="' . $row->id . '" tag-name="' . $row->name . '" loc-id="' . $loc->id . '" loc-name="' . $loc->name . '" loc-addr="' . $loc->address . '"><a>' . $row->name . ' ( ' . $loc->name . ', ' . $loc->address . ' )</a></li>
                            ';

                        }

                    }
                }
                $output .= '</ul>';
            } else {
                $output = null;
            }
            echo $output;
        }
    }

    function fetchLoc(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');

            $data = Location::where('name', 'LIKE', "%{$query}%")
                ->get();

            if(!$data->isEmpty()) {
                $output = '<ul class="list-group" style="display:block; position:relative; z-index: 999;">';
                foreach ($data as $row) {
                    $output .= '
                    <li class="location list-group-item" loc-name="' . $row->name . '" loc-addr="' . $row->address . '" loc-id="' . $row->id . '"><a>' . $row->name . ' ' . $row->address . '</a></li>
                ';
                }
                $output .= '</ul>';
            } else {
                $output = null;
            }
            echo $output;
        }
    }

    public function list($id = null)
    {
        $acc_id = auth()->user()->account->id;
        $spend = Spending::where('account_id',$acc_id);
        if($id) $spend = $spend->where('category_id',$id);
        $spend = $spend->with('category','loctag')->orderBy('created_at', 'desc')->get();

        return view('spendings.index',['data' => $spend]);
    }
}
