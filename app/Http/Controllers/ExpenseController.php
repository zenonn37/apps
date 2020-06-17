<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\resources\ExpenseResource;
use App\Http\Requests\ExpenseRequest;
use App\Expense;

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

    public function expense_total(){
        $user = auth()->user()->id;
         
        $expense = Expense::where('user_id',$user)->get();        

       
        $total = ExpenseResource::collection($expense)->sum('amount');

        $output =[
            'total' => $total
        ];

        return response()->json($output);

        


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
       
        $expense->amount = $request->amount;
        $expense->due = $request->due;
       
       
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
