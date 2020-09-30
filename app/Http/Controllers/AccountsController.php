<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acct = Account::where('user_id', auth()->user()->id)->get();

        $data = [
            'data' =>[
            'accounts' => AccountResource::collection($acct),
            'total' => AccountResource::collection($acct)->sum('balance')
            ]
        ];
        
        return response()->json($data);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        $account = new Account;
        $account->name = $request->name;
        $account->type = $request->type;
        $account->balance = $request->balance;
        $account->date = $request->date;
        $account->user_id  = auth()->user()->id;

        $account->save();

        return  new AccountResource($account);
        //
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountUpdateRequest $request, $id)
    {
        $acct = Account::find($id);


        $acct->name = $request->name;
        $acct->type = $request->type;
        // $acct->balance = $request->balance;
        $acct->date = $request->date;

        $acct->save();

        return new AccountResource($acct);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Account::destroy($id);

        return response()->json('Deleted', 200);
    }
}
