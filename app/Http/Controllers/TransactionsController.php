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


    public function acct($id){

        //get current date
        $current = Carbon::today();
        //subtract 30 days from current date
        $lastThirty =  Carbon::today()->subDays(30);
        //get data between today and thirty days ago

        $worth = Transaction::whereBetween('date',array($lastThirty->toDateString(), $current->toDateString()))
          ->where('acct_id',$id)
          ->get();
          $deposits = Transaction::whereBetween('date',array($lastThirty->toDateString(), $current->toDateString()))
          ->where('acct_id',$id)
          ->where('type','Deposit')
          ->get();
          $debits = Transaction::whereBetween('date',array($lastThirty->toDateString(), $current->toDateString()))
          ->where('acct_id',$id)
          ->where('type','Debit')
          ->get();

          //get daily spending avg
          $spent = TransactionResource::collection($debits)->sum('amount');

           $avg =  $spent / 30; 

          $balance =  TransactionResource::collection($deposits)->sum('amount')  -  TransactionResource::collection($debits)->sum('amount');

          $data = [
             'transactions' => TransactionResource::collection($worth)->count('id'),
             'debits'  => TransactionResource::collection($debits)->count('id'),
             'credits'  => TransactionResource::collection($deposits)->count('id'),
             'spent'  =>  $spent,
             'deposits' =>  TransactionResource::collection($deposits)->sum('amount'),
             'balance'  =>  $balance,
             'daily' => $avg,
          ];

          return response()->json($data);

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

    public function search($term,$id){

      
        $trans = Transaction::where('acct_id',$id)
        //refactor before final go. escape like term
        ->where('name','like',"%$term%" )
        ->orderBy('updated_at', 'DESC')
        ->get();
        return TransactionResource::collection($trans);
       // return response()->json($term);
    }


    public function category($term,$id){
       

        $trans = Transaction::where('acct_id',$id)
        ->where('category',$term)

        ->orderBy('date','DESC')
        ->get();



        return TransactionResource::collection($trans);
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

         //get current date
         $current = Carbon::today();
         //subtract 30 days from current date
         $lastThirty =  Carbon::today()->subDays(30);
         //get data between today and thirty days ago

       
            //check for at least one transaction else return [];

        // get deposits
         $deposits = Transaction::whereBetween('date',array($lastThirty->toDateString(), $current->toDateString()))
         ->where('user_id',$user)
         ->where('type', '=' ,'Deposit')
         ->groupBy('user_id')
         ->get(array(
               DB::raw('Sum(amount) as amount')
         ));

         

         $all = Transaction::whereBetween('date',array($lastThirty->toDateString(), $current->toDateString()))
         ->where('user_id',$user)
         ->where('type', '!=' ,'Deposit')
         ->groupBy('user_id')
         ->get(array(
               DB::raw('Sum(amount) as amount'),
               DB::raw('Count(id) as count'),
               DB::raw('AVG(amount) as average'),
           
         ));
         

    //     

    $trans = 0;
    $count = 0;
    $avg = 0;
    $dep = 0;

     foreach ($all as $value) {
         $trans = $value->amount;
         $count = $value->count;
         $avg = $value->average;
         
     }
     foreach ($deposits as $value) {
        $dep = $value->amount;
     }

      $daily = $trans / 30;
      $net = ($dep - $trans); 

    $data = [
         
         'deposits' => $dep,
         'amount' => $trans,
         'count' => $count,
         'average' => $avg,
         'daily' => $daily,
         'net' =>  $net
         
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
        $trans->category = $request->category;

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
    public function update(TransactionUpdateRequest $request, $id)
    {


        $transaction = Transaction::find($id);

        $transaction->name = $request->name;
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->date = $request->date;
        $transaction->category = $request->category;

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

        $destroy = 'Transaction Removed';


        return response()->json($destroy, 200);
    }
}
