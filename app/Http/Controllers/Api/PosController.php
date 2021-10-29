<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PosController extends Controller
{
    public function GetProduct($id){

        $product = DB::table('products')
            ->where('category_id',$id)
            ->get();
            return response()->json($product);
 
    } 

    public function saledone(Request $request){

   	 $validatedData = $request->validate([
      'customer_id' => 'required',
      'payby' => 'required',
   	 ]);
   
      $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;
      //Inserting Record to Sales Table
      $id = IdGenerator::generate(['table' => 'sales', 'length' => 12, 'prefix' => 'S' . date('ymd')]);
    $data = array();
    $data['id'] = $id;
    $data['customer_id'] = $request->customer_id;
    $data['qty'] = $request->total_quantity;
    $data['sub_total'] = $request->subtotal;
    $data['vat'] = $request->vat;
    $data['total'] = $request->total;
    $data['pay'] = $request->pay;
    $data['due'] = $request->due;
    $data['payby'] = $request->payby;
    $data['sale_date'] = $sysdate;
    $data['sale_month'] = date('F');
    $data['sale_year'] = date('Y');
    $data['user'] = $request->user;
    DB::table('sales')->insert($data);

    $contents = DB::table('pos')->where('user',$request->user)->get();

    //Inserting cart to Sales details Table
    $odata = array();
    foreach ($contents as $content) {
    $odata['sale_id'] = $id;
    $odata['product_id'] = $content->pro_id;
    $odata['pro_quantity'] = $content->pro_quantity;
    $odata['product_price'] = $content->product_price;
    $odata['sub_total'] = $content->sub_total;
    DB::table('sale_details')->insert($odata); 

       
        DB::table('products')
        	->where('id',$content->pro_id)
        	->update(['product_quantity' => DB::raw('product_quantity -' .$content->pro_quantity)]);

    }
      $group_id_cash = $settings->group_id_cash;
      $item_id_cash = $settings->item_id_cash;
      $group_id_cheque = $settings->group_id_cheque;
      $item_id_cheque = $settings->item_id_cheque;
      $group_id_sales = $settings->group_id_sales;
      $item_id_sales = $settings->item_id_sales;

        //store transaction for accounting - debit entry
        $idtrn = IdGenerator::generate(['table' => 'trn', 'length' => 12, 'prefix' => 'T' . date('ymd')]);
        $data = array();
        $data['id'] = $idtrn;
        $data['details'] = 'sales';

        if ($request->payby == 'Cash'){
            $data['group_id'] = $group_id_cash;
            $data['item_id'] = $item_id_cash;
        } 
        else {
            $data['group_id'] = $group_id_cheque;
            $data['item_id'] = $item_id_cheque;
        }

        $data['amount'] = $request->pay;
        $data['entry'] = 'DR';
        $data['trn'] = 'SALES';
        $data['ref'] = $id;
        $data['trndate'] = $sysdate;
        $data['user'] = $request->user;
        DB::table('trn')->insert($data);

        //store transaction for accounting - credit entry
        $idtrn = IdGenerator::generate(['table' => 'trn', 'length' => 12, 'prefix' => 'T' . date('ymd')]);
        $data = array();
        $data['id'] = $idtrn;
        $data['details'] = 'sales';
        $data['group_id'] = $group_id_cash;
        $data['item_id'] = $item_id_cash;
        $data['amount'] = $request->pay;
        $data['entry'] = 'CR';
        $data['trn'] = 'SALES';
        $data['ref'] = $id;
        $data['trndate'] = $sysdate;
        $data['user'] = $request->user;
        DB::table('trn')->insert($data);


    // deleting temporary data
    DB::table('pos')->where('user',$request->user)->delete();



    return response('Done'); 

   }

   public function SearchSalesDate(Request $request){
    // $salesdate = $request->date;
    // $newdate = new DateTime($salesdate);
    // $done = $newdate->format('d/m/Y'); 

    

    $sales = DB::table('sales')
        ->join('customers','sales.customer_id','customers.id')
        ->select('customers.name','sales.*')
        ->where('sales.sale_date',$request->date)
        ->get();

    return response()->json($sales);

  }

  public function TodaySales(){
    $settings = DB::table('settings')->first();
    $sysdate = $settings->sysdate;
    //$date = date('d/m/Y');
    $sales = DB::table('sales')->where('sale_date',$sysdate)->sum('total');
    return response()->json($sales);
  }

  public function TodayIncome(){
    $settings = DB::table('settings')->first();
    $sysdate = $settings->sysdate;
    //$date = date('d/m/Y');
    $income = DB::table('sales')->where('sale_date',$sysdate)->sum('pay');
    return response()->json($income);
  }

  public function TodayDue(){
    $settings = DB::table('settings')->first();
    $sysdate = $settings->sysdate;
    //$date = date('d/m/Y');
    $todaydue = DB::table('sales')->where('sale_date',$sysdate)->sum('due');
    return response()->json($todaydue);
  }


  public function TodayExpense(){
    //$date = date('d/m/Y');
    $settings = DB::table('settings')->first();
    $sysdate = $settings->sysdate;
     $expense = DB::table('expenses')->whereDate('expense_date',$sysdate)->sum('amount');
     return response()->json($expense);
   }

    public function TodayStockout(){

    $product = DB::table('products')->where('product_quantity','<','1')->get();
    return response()->json($product);

    }


  public function UserExpense($id){

    $settings = DB::table('settings')->first();
    $sysdate = $settings->sysdate;

    $users = DB::table('users')
      ->where('name',$id)
      ->first();
    $role = $users->role;

    if ($role == 'admin') {
      $expense = DB::table('expenses')
      ->where('expenses.user','!=',$id)
      ->select('expenses.user')
      ->distinct()
      ->get();
      return response()->json($expense);
    } else {
      // $expense = DB::table('expenses')
      // ->where('expenses.user','=',$id)
      // ->select('expenses.user')
      // ->distinct()
      // ->get();
      // return response()->json($expense);

      return response('Done');
    }
   }

   public function UserJournal($id){

    $settings = DB::table('settings')->first();
    $sysdate = $settings->sysdate;

    $users = DB::table('users')
      ->where('name',$id)
      ->first();
    $role = $users->role;

    if ($role == 'admin') {
      $journal = DB::table('journals')
      ->where('journals.user','!=',$id)
      ->select('journals.user')
      ->distinct()
      ->get();
      return response()->json($journal);
    } else {

      return response('Done');
    }
   }

   

}
