<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use DB;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservation = DB::table('reservations')->orderBy('id','ASC')->get();
        return response()->json($reservation);
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
            'customer_id' => 'required|max:255',
            'idcategory' => 'required',
            'idroom' => 'required',
            'numrooms' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'phone' => 'required',
            'email' => 'required',
           ]);
   
           $settings = DB::table('settings')->first();
           $sysdate = $settings->sysdate;
   
           $mydate = DateTime::createFromFormat('Y-m-d', $sysdate)->format('ymd');
           $id = IdGenerator::generate(['table' => 'reservations', 'length' => 12, 'prefix' => 'R' . $mydate]);
            $reservation = new Reservation;
            $reservation->id = $id;
            $reservation->idcategory = $request->idcategory;
            $reservation->idroom = $request->idroom;
            $reservation->date_from = $request->date_from;
            $reservation->date_to = $request->date_to;
            $reservation->numrooms = $request->numrooms;
            $reservation->customer_id = $request->customer_id;
            $reservation->phone = $request->phone;
            $reservation->email = $request->email;
            $reservation->notes = $request->notes;
           
            $reservation->save(); 
   
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
    public function update(Request $request, $id)
    {
        $data = array();
        $data['idcategory'] = $request->idcategory;
        $data['idroom'] = $request->idroom;
        $data['date_from'] = $request->date_from;
        $data['date_to'] = $request->date_to;
        $data['numrooms'] = $request->numrooms;
        $data['customer_id'] = $request->customer_id;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['notes'] = $request->notes;
        $user = DB::table('reservations')->where('id',$id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = DB::table('reservations')->where('id',$id)->first();
        DB::table('reservations')->where('id',$id)->delete();
       
    }
}
