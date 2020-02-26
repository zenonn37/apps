<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Http\Resources\TransactionResource;
use App\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Transliterator;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        //get current date
        $current = Carbon::today();
        //subtract 30 days from current date
        $lastThirty =  Carbon::today()->subDays(30);
        //get data between today and thirty days ago



        $trans = Transaction::whereBetween('date', array($lastThirty->toDateString(), $current->toDateString()))
            ->where('acct_id', $id)
            ->orderBy('date', 'desc')
            ->paginate(18);

        return TransactionResource::collection($trans);

        //return response($trans);
    }

    //add all transaction for per day

    public function  addTransactions($id)
    {
        $trans = Transaction::where('acct_id', $id)

            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('SUM(amount) as transactions')
            ));

        return response()->json($trans);
    }
















    public function singleDay(Request $request, $id)
    {
        $trans = Transaction::where('date', $request->date)
            ->where('acct_id', $id)->orderBy('date', 'desc')
            ->paginate(12);
        return TransactionResource::collection($trans);
    }

    public function dateRange(Request $request, $id)
    {
        $trans = Transaction::whereBetween('date', array($request->date, $request->date2))
            ->where('acct_id', $id)->orderBy('date', 'desc')->paginate(18);
        return TransactionResource::collection($trans);
    }


    public function transMonth()
    {
        $user = auth()->user()->id;

        //get current date
        $current = Carbon::today();
        //subtract 30 days from current date
        $lastThirty =  Carbon::today()->subDays(30);
        //get data between today and thirty days ago
        $trans = Transaction::whereBetween('date', array($lastThirty->toDateString(), $current->toDateString()))
            ->where('user_id', $user)
            ->groupBy('date')
            ->get(array(
                DB::raw('date'),
                DB::raw('SUM(amount) as amount')
            ));


        return response()->json($trans);
    }

    public function netWorth()
    {

        $user = auth()->user()->id;

         //get deposits
         $deposits = Transaction::where('user_id',$user)
          ->where('type', '=' ,'Deposit')
          ->groupBy('user_id')
          ->get(array(
                DB::raw('Sum(amount) as amount')
          ));

          $credit = Transaction::where('user_id',$user)
          ->where('type', '!=' ,'Deposit')
          ->groupBy('user_id')
          ->get(array(
                DB::raw('Sum(amount) as amount')
          ));

          $count = Transaction::where('user_id',$user)
          ->where('type', '!=' ,'Deposit')
          ->get(array(
            DB::raw('Count(id) as count')
          ));

          $avg = Transaction::where('user_id',$user)
          ->where('type', '!=' ,'Deposit')
          ->groupBy('user_id')
          ->get(array(
           DB::raw('AVG(amount) as average')
          ));

     $trans = Transaction::where('user_id', $user)
     ->where('type', '!=' ,'Deposit')
     ->get(array(
         DB::raw('amount')
     ));

    

         $net = $deposits[0]->amount - $credit[0]->amount;
        $data = [
            'transactions' => $credit[0]->amount,
            'deposits' => $deposits[0]->amount,
            'spent' => $net,
            'count' => $count[0]->count,
            'avg' => $avg[0]->average,
             'all' => $trans,
          
        ];

        return response()->json($data);
    }



    public function total($id)
    {
        $trans = Transaction::where('acct_id', $id)->get();



        $credit = array();
        $debit = array();

        foreach ($trans as $key => $value) {

            if ($value->type != "Deposit") {
                array_push($debit, $value->amount);
            } else {
                array_push($credit, $value->amount);
            }
        }

        $dep = array_sum($credit);
        $deb =  array_sum($debit);

        $net = $dep - $deb;
        $data = [
            'debit' => $deb,
            'credit' => $dep,
            'net' => $net
        ];


        $account = Account::find($id);


        $account->balance = $net;

        $account->save();





        return  response()->json($data);
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

        $date = Carbon::parse($request->date);
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
