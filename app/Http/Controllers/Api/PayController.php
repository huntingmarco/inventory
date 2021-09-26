<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pay;
use DB;
use DateTime;

class PayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pay = DB::table('pays')->orderBy('id','DESC')->get();
        return response()->json($pay);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'payfrom' => 'required',
            'payto' => 'required',
            'details' => 'required|max:100',
            'transact_date' => 'required|max:100',
            'user' => 'required',
        ]);

        $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;

        $payf = DateTime::createFromFormat('Y-m-d', $request->payfrom)->format('ymd');
        $payt = DateTime::createFromFormat('Y-m-d', $request->payto)->format('ymd');

        $pay = new Pay;
        $pay->id = $payf . '-' . $payt;
        $pay->payfrom = $request->payfrom;
        $pay->payto = $request->payto;
        $pay->details = $request->details;
        $pay->transact_date = $request->transact_date;
        $pay->user = $request->user;
        $pay->user = 'CREATED';
        $pay->save(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pay = DB::table('pays')->where('id',$id)->first();
        return response()->json($pay);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
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
        $data['transact_date'] = $request->transact_date;
        $user = DB::table('pays')->where('id',$id)->update($data);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pays')->where('id',$id)->delete();
    }


    public function GetPayStatus($id){
        $settings = DB::table('pays')->where('id',$id)->first();
        $status = $settings->status;
        return response()->json($status);
    }
}
