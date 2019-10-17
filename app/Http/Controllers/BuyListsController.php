<?php

namespace App\Http\Controllers;

use App\BuyListItem;
use App\Location;
use App\LocTag;
use App\Tag;
use App\BuyList;
use App\Category;
use Illuminate\Http\Request;

class BuyListsController extends Controller
{
    public function index()
    {}

    public function createList()
    {
        $acc_id = auth()->user()->account->id;

        $list = BuyList::create(['account_id'=>$acc_id]);

        return redirect('/buylists/list/'.$list->id);
    }

    public function single($id)
    {
        $acc_id = auth()->user()->account->id;
        $list = BuyList::whereId($id)->where('account_id',$acc_id)->with('listItems.tag','listItems.location','listItems.loctag','listItems')->first();
        $cats = Category::where('section','spendings')->get()->toArray();

        //dd($list);die();
        return view('buylists.single',['data'=>$list,'cats'=>$cats]);
    }

    function fetch(Request $request)
    {
        //var_dump($request->request);
        if($request->get('query'))
        {
            $query = $request->get('query');

            $data = Tag::with('locations')
                ->where('name', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {

                $output .= '
                    <li class="tag" el-unit="'.$row->unit.'" tag-id="'.$row->id.'" ><a href="#">'.$row->name.'</a></li>
                ';

                if($row->locations){

                    foreach ($row->locations as $loc){
                        $loctag = LocTag::where('tag_id',$row->id)->where('location_id',$loc->id)->first();

                        $output .= '
                            <li class="tag" el-unit="'.$row->unit.'" tag-id="'.$row->id.'" tag-name="'.$row->name.'" loc-id="'.$loc->id.'" loc-name="'.$loc->name.'" loc-addr="'.$loc->address.'" tag-price="'.$loctag->unit_price.'"><a href="#">'.$row->name.' ( '.$loc->name.', '.$loc->address.' )</a></li>
                        ';

                    }

                }
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    function store(Request $data)
    {
        $acc_id = auth()->user()->account->id;

        //dd($data);die();

        if($data->tag !== null){

            if($data->list_id === null){

                $list = BuyList::create([
                    'account_id' => $acc_id
                ]);

                $list_id = $list->id;

            } else {
                $list_id = $data->list_id;
            }

            if($data->tag_id === null){

                $tag = Tag::where('name',$data->tag)->first();

                if($tag === null){
                    $tag = Tag::create([
                        'name'=>$data->tag,
                        'unit'=>$data->tag_unit
                    ]);
                }

                $tag_id = $tag->id;

            } else {
                $tag_id = $data->tag_id;
            }

            $loc_id = null;

            if($data->location_id === null){
                if($data->location !== null){

                    $loc = Location::where('name',$data->location);

                    if($data->address !== null){
                        $loc = $loc->where('address',$data->address);
                    }

                    $loc = $loc->first();

                    if($loc === null){
                        $loc = Location::create([
                            'name'=>$data->location,
                            'address'=>$data->address
                        ]);
                    }

                    $loc_id = $loc->id;

                }
            } else {
                $loc_id = $data->location_id;
            }

            $item_data = [
                'buylist_id'=>$list_id,
                'tag_id'=>$tag_id,
                'payed_sum'=>$data->total_price,
                'qty'=>$data->qty,
                'location_id'=>$loc_id
            ];

            $item = BuyListItem::create($item_data);
        }

        return redirect('/buylists/list/'.$list_id);

    }
}
