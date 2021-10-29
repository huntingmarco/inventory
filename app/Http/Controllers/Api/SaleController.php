<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SaleController extends Controller
{
    public function TodaySales(){
     
        //$data = date('d/m/Y');

        $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;

        $sale = DB::table('sales')
           ->join('customers','sales.customer_id','customers.id')
           ->where('sale_date',$sysdate)
           ->select('customers.name','sales.*')
           ->orderBy('sales.id','DESC')->get();
           return response()->json($sale); 
    }

    public function SaleSummary($id){
        //return response()->json($id);
        $sale = DB::table('sales')
            ->join('customers','sales.customer_id','customers.id')
            ->where('sales.id',$id)
            ->select('customers.name','customers.phone','customers.address','sales.*')
            ->first();
            return response()->json($sale);
    }
 
 
    public function SaleDetails($id){
        $details = DB::table('sale_details')
            ->join('products','sale_details.product_id','products.id')
            ->where('sale_details.sale_id',$id)
            ->select('products.product_name','products.product_code','products.image','sale_details.*')
            ->get();
            return response()->json($details);
    }
    
}
