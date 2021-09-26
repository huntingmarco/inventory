<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use DB;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
        
    // }
    

    public function myExpenses(Request $request)
    {
        $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;

        $expense = DB::table('expenses')
        ->select('expenses.*')
        ->whereDate('expenses.expense_date',$sysdate)
        ->where('expenses.user',$request->user)
        ->where('expenses.status','!=','CANCELLED')
        ->get();
       
        return response()->json($expense);

    }

    public function OtherUserExpenses($id){


        $settings = DB::table('settings')->first();
          $sysdate = $settings->sysdate;
  
          $expense = DB::table('expenses')
          ->select('expenses.*')
          ->whereDate('expenses.expense_date',$sysdate)
          ->where('expenses.user',$id)
          ->where('expenses.status','!=','CANCELLED')
          ->get();
  
  
          return response()->json($expense);
     }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'details' => 'required',
            'group_id' => 'required',
            'item_id' => 'required',
            'amount' => 'required',
        ]);

        $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;

        $mydate = DateTime::createFromFormat('Y-m-d', $sysdate)->format('ymd');
        $id = IdGenerator::generate(['table' => 'expenses', 'length' => 12, 'prefix' => 'E' . $mydate]);
        $expense = new Expense;
        $expense->id = $id;
        $expense->details = $request->details;
        $expense->group_id = $request->group_id;
        $expense->item_id = $request->item_id;
        $expense->amount = $request->amount;
        $expense->expense_date = $sysdate;
        $expense->user = $request->user;
        $expense->status = 'SAVED';
        $expense->save();

        // $data = array();
        // $data['details'] = $request->details;
        // $data['group_id'] = $request->group_id;
        // $data['item_id'] = $request->item_id;
        // $data['amount'] = $request->amount;
        // $data['expense_date'] = $sysdate;
        // $data['user'] = $request->user;
        // $expense_id = DB::table('expense')->insertGetId($data);

        
        // $group_id_cash = $settings->group_id_cash;
        // $item_id_cash = $settings->item_id_cash;

        //store transaction for accounting - debit entry
        // $idtrn = IdGenerator::generate(['table' => 'trn', 'length' => 12, 'prefix' => 'T' . date('ymd')]);
        // $data = array();
        // $data['id'] = $idtrn;
        // $data['details'] = $request->details;
        // $data['group_id'] = $request->group_id;
        // $data['item_id'] = $request->item_id;
        // $data['amount'] = $request->amount;
        // $data['entry'] = 'DR';
        // $data['trn'] = 'EXPENSE';
        // $data['ref'] = $id;
        // $data['trndate'] = $sysdate;
        // $data['user'] = $request->user;
        // DB::table('trn')->insert($data);

        //store transaction for accounting - credit entry
        // $idtrn = IdGenerator::generate(['table' => 'trn', 'length' => 12, 'prefix' => 'T' . date('ymd')]);
        // $data = array();
        // $data['id'] = $idtrn;
        // $data['details'] = $request->details;
        // $data['group_id'] = $group_id_cash;
        // $data['item_id'] = $item_id_cash;
        // $data['amount'] = $request->amount;
        // $data['entry'] = 'CR';
        // $data['trn'] = 'EXPENSE';
        // $data['ref'] = $id;
        // $data['trndate'] = $sysdate;
        // $data['user'] = $request->user;
        // DB::table('trn')->insert($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = DB::table('expenses')->where('id',$id)->first();
        return response()->json($expense);
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
        $data = array();
        $data['details'] = $request->details;
        $data['group_id'] = $request->group_id;
        $data['item_id'] = $request->item_id;
        $data['amount'] = $request->amount;
        $user = DB::table('expenses')->where('id',$id)->update($data);
    }

    public function cancelExpense($id)
    {
        $data = array();
        $data['status'] = 'CANCELLED';
        $user = DB::table('expenses')->where('id',$id)->update($data);

        // delete accounting entries
        DB::table('trn')->where('ref',$id)->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('expenses')->where('id',$id)->delete();
    }
}
