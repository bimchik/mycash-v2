<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    private $section;

    public function index($section)
    {
        $this->section = $section;
        return view('categories.add', ['section' => $this->section]);
    }

    public function store(Request $data)
    {
        $acc_id = auth()->user()->account->id;

        $bill = 1;

        if($data->commun_bill == null){
            $bill = 0;
        }

        $cat = Category::create(
            [
                "account_id" => $acc_id,
                "name" => $data->name,
                "slug" => Str::slug($data->name),
                "section" => $data->section,
                "commun_bill" => $bill
            ]
        );

        return redirect()->back();
    }
}
