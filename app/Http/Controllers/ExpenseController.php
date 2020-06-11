<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\resources\ExpenseResource;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;

        $expense = Expense::where('user_id',$user)->get();

        return ExpenseResource::collection($expense);

        //
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $expense = new Expense();
        
        $userId = auth()->user()->id;
        $expense->name = $request->name;
        $expense->user_id = $userId;
        $expense->type = $request->type;
        $expense->amount = $request->amount;
        $expense->due = $request->due;
        $expense->paid = $request->paid;
        $expense->repeated = $request->repeated;
        $expense->category = $request->category;

        $expense->save();

        return new ExpenseResource($expense);


    }

   
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::destroy($id);

        return response()->json('Record Destroyed');
    }
}
