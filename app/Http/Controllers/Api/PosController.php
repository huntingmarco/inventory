<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DateTime;

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
   
    $data = array();
    $data['customer_id'] = $request->customer_id;
    $data['qty'] = $request->total_quantity;
    $data['sub_total'] = $request->subtotal;
    $data['vat'] = $request->vat;
    $data['total'] = $request->total;
    $data['pay'] = $request->pay;
    $data['due'] = $request->due;
    $data['payby'] = $request->payby;
    $data['sale_date'] = date('d/m/Y');
    $data['sale_month'] = date('F');
    $data['sale_year'] = date('Y');
    $sale_id = DB::table('sales')->insertGetId($data);

    $contents = DB::table('pos')->get();

    $odata = array();
    foreach ($contents as $content) {
    $odata['sale_id'] = $sale_id;
    $odata['product_id'] = $content->pro_id;
    $odata['pro_quantity'] = $content->pro_quantity;
    $odata['product_price'] = $content->product_price;
    $odata['sub_total'] = $content->sub_total;
    DB::table('sale_details')->insert($odata); 

       
        DB::table('products')
        	->where('id',$content->pro_id)
        	->update(['product_quantity' => DB::raw('product_quantity -' .$content->pro_quantity)]);

    }
    DB::table('pos')->delete();
    return response('Done'); 

   }

   public function SearchSalesDate(Request $request){
    $salesdate = $request->date;
    $newdate = new DateTime($salesdate);
    $done = $newdate->format('d/m/Y'); 

    $sales = DB::table('sales')
        ->join('customers','sales.customer_id','customers.id')
        ->select('customers.name','sales.*')
        ->where('sales.sale_date',$done)
        ->get();

    return response()->json($sales);

  }

  public function TodaySales(){
    $date = date('d/m/Y');
    $sales = DB::table('sales')->where('sale_date',$date)->sum('total');
    return response()->json($sales);
  }

  public function TodayIncome(){
    $date = date('d/m/Y');
    $income = DB::table('sales')->where('sale_date',$date)->sum('pay');
    return response()->json($income);
  }

  public function TodayDue(){
    $date = date('d/m/Y');
    $todaydue = DB::table('sales')->where('sale_date',$date)->sum('due');
    return response()->json($todaydue);
  }


  public function TodayExpense(){
    $date = date('d/m/Y');
     $expense = DB::table('expenses')->where('expense_date',$date)->sum('amount');
     return response()->json($expense);
   }

    public function TodayStockout(){

    $product = DB::table('products')->where('product_quantity','<','1')->get();
    return response()->json($product);

    }

}
