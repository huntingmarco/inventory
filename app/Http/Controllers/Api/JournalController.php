<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Journal;
use DB;
use DateTime;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    public function myJournal(Request $request)
    {
        $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;

        $journal = DB::table('journals')
        ->select('journals.*')
        ->whereDate('journals.entry_date',$sysdate)
        ->where('journals.user',$request->user)
        ->where('journals.status','!=','CANCELLED')
        ->get();
       
        return response()->json($journal);

    }

    public function OtherUserJournal($id){


        $settings = DB::table('settings')->first();
          $sysdate = $settings->sysdate;
  
          $journal = DB::table('journals')
          ->select('journals.*')
          ->whereDate('journals.entry_date',$sysdate)
          ->where('journals.user',$id)
          ->where('journals.status','!=','CANCELLED')
          ->get();
  
  
          return response()->json($journal);
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
        $id = IdGenerator::generate(['table' => 'journals', 'length' => 12, 'prefix' => 'J' . $mydate]);
        $journal = new Journal;
        $journal->id = $id;
        $journal->details = $request->details;
        $journal->group_id = $request->group_id;
        $journal->item_id = $request->item_id;
        $journal->amount = $request->amount;
        $journal->entry_date = $sysdate;
        $journal->user = $request->user;
        $journal->status = 'SAVED';
        $journal->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = DB::table('journals')->where('id',$id)->first();
        return response()->json($journal);
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
        $user = DB::table('journals')->where('id',$id)->update($data);
    }

    public function cancelJournal($id)
    {
        $data = array();
        $data['status'] = 'CANCELLED';
        $user = DB::table('journals')->where('id',$id)->update($data);

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
        //
    }
}
