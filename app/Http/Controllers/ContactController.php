<?php

namespace App\Http\Controllers;

use App\User;
use App\Contact;
use DB;
use Illuminate\Http\Request;
use App\Account;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = auth()->user()->account->contacts();

        return view('contacts.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('contacts.add');
    }

    public function search(Request $data)
    {
        $data = $data->search_contact;
        $user_id = auth()->user()->id;
        $results = User::where('name', 'like','%'.$data.'%')->orWhere('email', 'like','%'.$data.'%')->where('id','!=',$user_id)->with('account')->get()->toArray();

        return view('contacts.add',['results'=>$results]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $data)
    {
        $user_id = auth()->user()->account->id;
        $data = $data->contact_id;
        $insert = Contact::create([ 'account_id' => $user_id, 'contact_id' => $data ]);

        return redirect('/contacts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }

    public function requests()
    {
        return view('requests.index');
    }

    public function accept(Request $request)
    {
        $id = $request->req_id;

        $req = DB::table('contacts')->where('id',$id)->update(['accept'=>1]);

        return redirect('/requests');

    }

    public function cancel(Request $request)
    {
        $id = $request->req_id;

        $req = DB::table('contacts')->where('id',$id)->delete();

        return redirect('/requests');
    }
}
