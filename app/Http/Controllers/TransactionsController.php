<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $trans = Transaction::where('acct_id', $id)->orderBy('date', 'desc')->paginate(12);

        return TransactionResource::collection($trans);

        return response($trans);
    }

    public function total(Request $request, $id)
    {
        $trans = Transaction::where('acct_id', $id)->get();


        $out = $trans->map(function ($trans) {
            return [
                'type' => $trans->type,
                'amount' => $trans->amount,

            ];
        });

        $account = Account::find($id);

        if (!empty($request->balance)) {
            $account->balance = $request->balance;

            $account->save();
        }





        // $total = $trans->map(function ($tran) {

        //     $array = [];
        //     array_push($array, $tran->amount);
        //     return $array;
        //     //print_r($tran->amount . '<br>');
        //     //print_r($sum . '<br>');


        // });
        // $credit = [];
        // $debit = [];
        // foreach ($trans as $key => $value) {
        //     if ($value->type == "Deposit") {
        //         array_push($credit, $value->amount);
        //     }
        //     if ($value->type != "Deposit") {
        //         array_push($debit, $value->amount);
        //     }
        //     // array_push($bal, $value->amount);
        // }
        // // print_r($bal . '<br>');
        // print(array_sum($credit) . '<br/>');
        // print(array_sum($debit) . '<br/>');

        // $loss = array_sum($credit);
        // $gain = array_sum($debit);

        // $net = $gain - $loss;

        // $a = ($loss > $gain) ? -$net : $net;



        // print($a);

        //print_r(array_sum($total));

        // print_r($total);





        return  response()->json($out);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $trans = new Transaction;
        $trans->user_id = auth()->user()->id;
        $trans->acct_id = $request->acct_id;
        $trans->name = $request->name;
        $trans->type = $request->type;
        $trans->amount = $request->amount;
        $trans->date = $request->date;

        $trans->save();

        return response($trans);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, $id)
    {


        $transaction = Transaction::find($id);

        $transaction->name = $request->name;
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->date = $request->date;

        $transaction->save();


        return response($transaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $request, $id)
    {
        Transaction::destroy($id);

        $test = 'Transaction Removed';


        return response()->json($test, 200);
    }
}
