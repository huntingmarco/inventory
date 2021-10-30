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

    public function GenerateTrialBalance(Request $request)
    {
        $rdate = DateTime::createFromFormat('Y-m-d', $request->date)->format('ymd');
        
        //refresh temp table
        $dropTempTables = DB::statement('DROP TABLE IF EXISTS trial' . $rdate . $request->user );

        //Create temporary table
       $createIncomeTable = DB::unprepared('create table trial' . $rdate . $request->user . 
       ' (id bigint not null auto_increment,' .
       'item_id varchar(20) not null default 0,' .
       'item_name varchar(50) not null default "",' . 
       'details varchar(50) not null default "",' . 
       'trn varchar(50) not null default "",' . 
       'ref varchar(50) not null default "",' . 
       'group_id char(7) not null default 0,' .
       'group_name varchar(50) not null default "",' . 
       'grouptype char(1) not null default 0 default "",' .
       'debit double not null default 0,' . 
       'credit double not null default 0, ' .
       'bal double not null default 0, ' .
       'primary key(id))');

       //Get Transaction then insert to temporary table
    //    DB::statement('INSERT INTO trial' . $rdate . $request->user . ' (item_id,item_name,details,trn,ref,group_id,group_name,grouptype,debit,credit) ' .
    //    ' Select a.item_id, c.item_name, a.details, a.trn, a.ref, ' .
    //    ' b.group_id, b.group_name, b.grouptype, if(a.entry="DR",a.amount,0) As tdebit, ' .
    //    ' if(a.entry="CR",a.amount,0) As tcredit  ' .
    //    ' From trn as a Inner Join ' .
    //    ' acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
    //    ' Inner Join ' .
    //    ' acctitems as c On Trim(a.item_id) = Trim(c.item_id) ' .
    //    ' Where a.trndate = "' . $request->date .  '" ' .
    //    ' Order By b.grouptype, a.item_id');

       DB::statement('INSERT INTO trial' . $rdate . $request->user . ' (item_name,debit,credit) ' .
       ' Select  c.item_name, sum(if(a.entry="DR",a.amount,0)) As tdebit, ' .
       ' sum(if(a.entry="CR",a.amount,0)) As tcredit  ' .
       ' From trn as a Inner Join ' .
       ' acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
       ' Inner Join ' .
       ' acctitems as c On Trim(a.item_id) = Trim(c.item_id) ' .
       ' Where a.trndate = "' . $request->date .  '" ' .
       ' Group By c.item_name ');



       $trial = DB::table('trial' . $rdate . $request->user)
        ->select('trial' . $rdate . $request->user . '.*')
          ->get();

       //refresh temp table
       //$dropTempTables = DB::statement('DROP TABLE IF EXISTS trial' . $rdate . $request->user );

        return response()->json($trial);

    }

    public function GenerateIncome(Request $request)
    {
      
        $rdate = DateTime::createFromFormat('Y-m-d', $request->date)->format('ymd');

        //refresh temp table
       $dropTempTables = DB::statement('DROP TABLE IF EXISTS income' . $rdate . $request->user );

       //Create temporary table
       $createIncomeTable = DB::unprepared('create table income' . $rdate . $request->user . 
       ' (id bigint not null auto_increment,' .
       'item_id varchar(20) not null default 0,' .
       'item_name varchar(50) not null,' . 
       'group_id char(7) not null default 0,' .
       'group_name varchar(50) not null,' . 
       'grouptype char(1) not null default 0,' .
       'debit double not null default 0,' . 
       'credit double not null default 0, ' .
       'bal double not null default 0, ' .
       'primary key(id))');

      
        //Select Income and Expense item then insert to temporary table
        DB::statement('INSERT INTO income' . $rdate . $request->user . ' (item_id,item_name,group_id,group_name,grouptype,debit,credit,bal) ' .
        ' Select a.item_id, a.item_name, ' .
        ' b.group_id, b.group_name, b.grouptype, a.debit As tdebit, ' .
        ' a.credit As tcredit,  ' .
        ' a.bal As tbal  ' .
        ' From acctitems as a Inner Join ' .
        ' acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
        ' Where UCase(Trim(b.grouptype)) = "D" Or ' .
        ' UCase(Trim(b.grouptype)) = "E" ' .
        ' Group By a.item_id,b.group_id ' .
        ' Order By b.grouptype, a.item_id');


        DB::statement('UPDATE income' . $rdate . $request->user . ' as items, ( ' .
        'Select a.item_id,Sum(if(c.entry="DR",c.amount,0)) As tdebit, Sum(if(c.entry="CR",c.amount,0)) As tcredit ' .
        ' From acctitems as a Left Join trn as c On Trim(c.item_id) = Trim(a.item_id) ' . 
        ' Inner Join acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
        ' Where (UCase(Trim(b.grouptype)) = "D" Or UCase(Trim(b.grouptype)) = "E") ' .
        ' and c.trndate <= "' . $request->date .  '" ' .
        ' Group By a.item_id ' .
        ' Order By a.item_id) as trn ' .
        ' SET items.debit = trn.tdebit, items.credit = trn.tcredit' .
        ' WHERE items.item_id=trn.item_id');

         //update income account
         DB::update(
            'update income' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.credit-a.debit where b.grouptype = ?',
            ['D']);

        //update expense account
        DB::update(
            'update income' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.debit-a.credit where b.grouptype = ?',
            ['E']);

        
        $income = DB::table('income' . $rdate . $request->user)
        ->select('income' . $rdate . $request->user . '.*')
          ->get();

        //refresh temp table
       $dropTempTables = DB::statement('DROP TABLE IF EXISTS income' . $rdate . $request->user );

        return response()->json($income);

    }


    public function GenerateBalance(Request $request)
    {
        
        $rdate = DateTime::createFromFormat('Y-m-d', $request->date)->format('ymd');

        //refresh temp table
       $dropTempTables = DB::statement('DROP TABLE IF EXISTS balance' . $rdate . $request->user );

       //Create temporary table
       $createIncomeTable = DB::unprepared('create table balance' . $rdate . $request->user . 
       ' (id bigint not null auto_increment,' .
       'item_id varchar(20) not null default 0,' .
       'item_name varchar(50) not null,' . 
       'group_id char(7) not null default 0,' .
       'group_name varchar(50) not null,' . 
       'grouptype char(1) not null default 0,' .
       'debit double not null default 0,' . 
       'credit double not null default 0, ' .
       'bal double not null default 0, ' .
       'primary key(id))');

       //Select Assets, Liabilities and Capital item then insert to temporary table
       DB::statement('INSERT INTO balance' . $rdate . $request->user . ' (item_id,item_name,group_id,group_name,grouptype,debit,credit,bal) ' .
       ' Select a.item_id, a.item_name, ' .
       ' b.group_id, b.group_name, b.grouptype, a.debit As tdebit, ' .
       ' a.credit As tcredit,  ' .
       ' a.bal As tbal  ' .
       ' From acctitems as a Inner Join ' .
       ' acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
       ' Where UCase(Trim(b.grouptype)) = "A" ' .
       ' or UCase(Trim(b.grouptype)) = "B" ' .
       ' or UCase(Trim(b.grouptype)) = "C" ' .
       ' Group By a.item_id,b.group_id ' .
       ' Order By b.grouptype, a.item_id');

        //Get transaction and update amount to account item
       DB::statement('UPDATE balance' . $rdate . $request->user . ' as items, ( ' .
       'Select a.item_id,Sum(if(c.entry="DR",c.amount,0)) As tdebit, Sum(if(c.entry="CR",c.amount,0)) As tcredit ' .
       ' From acctitems as a Left Join trn as c On Trim(c.item_id) = Trim(a.item_id) ' . 
       ' Inner Join acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
       ' Where (UCase(Trim(b.grouptype)) = "A" Or UCase(Trim(b.grouptype)) = "B" Or UCase(Trim(b.grouptype)) = "C") ' .
       ' and c.trndate <= "'  . $request->date .  '" ' .
       ' Group By a.item_id ' .
       ' Order By a.item_id) as trn ' .
       ' SET items.debit = trn.tdebit, items.credit = trn.tcredit' .
       ' WHERE items.item_id=trn.item_id');

       //-------------------------------------------------
       //Get Net Income Begin
       //-------------------------------------------------
       //Get transaction and update amount to account item
    

    //refresh temp table
    $dropTempTables = DB::statement('DROP TABLE IF EXISTS income' . $rdate . $request->user );

    //Create temporary table
    $createIncomeTable = DB::unprepared('create table income' . $rdate . $request->user . 
    ' (id bigint not null auto_increment,' .
    'item_id varchar(20) not null default 0,' .
    'item_name varchar(50) not null,' . 
    'group_id char(7) not null default 0,' .
    'group_name varchar(50) not null,' . 
    'grouptype char(1) not null default 0,' .
    'debit double not null default 0,' . 
    'credit double not null default 0, ' .
    'bal double not null default 0, ' .
    'primary key(id))');

   
     //Select Income and Expense item then insert to temporary table
     DB::statement('INSERT INTO income' . $rdate . $request->user . ' (item_id,item_name,group_id,group_name,grouptype,debit,credit,bal) ' .
     ' Select a.item_id, a.item_name, ' .
     ' b.group_id, b.group_name, b.grouptype, a.debit As tdebit, ' .
     ' a.credit As tcredit,  ' .
     ' a.bal As tbal  ' .
     ' From acctitems as a Inner Join ' .
     ' acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
     ' Where UCase(Trim(b.grouptype)) = "D" Or ' .
     ' UCase(Trim(b.grouptype)) = "E" ' .
     ' Group By a.item_id,b.group_id ' .
     ' Order By b.grouptype, a.item_id');


     DB::statement('UPDATE income' . $rdate . $request->user . ' as items, ( ' .
     'Select a.item_id,Sum(if(c.entry="DR",c.amount,0)) As tdebit, Sum(if(c.entry="CR",c.amount,0)) As tcredit ' .
     ' From acctitems as a Left Join trn as c On Trim(c.item_id) = Trim(a.item_id) ' . 
     ' Inner Join acctgroups as b On Trim(a.group_id) = Trim(b.group_id) ' .
     ' Where (UCase(Trim(b.grouptype)) = "D" Or UCase(Trim(b.grouptype)) = "E") ' .
     ' and c.trndate <= "' . $request->date .  
     '" Group By a.item_id ' .
     ' Order By a.item_id) as trn ' .
     ' SET items.debit = trn.tdebit, items.credit = trn.tcredit' .
     ' WHERE items.item_id=trn.item_id');

      //update income account
      DB::update(
         'update income' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.credit-a.debit where b.grouptype = ?',
         ['D']);

     //update expense account
     DB::update(
         'update income' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.debit-a.credit where b.grouptype = ?',
         ['E']);


    //     //-------------------------------------------------
    //    //Get Net Income End
    //    //-------------------------------------------------

        //update assets account
        DB::update(
            'update balance' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.debit-a.credit where b.grouptype = ?',
            ['A']);

        //update liabilities account
        DB::update(
            'update balance' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.credit-a.debit where b.grouptype = ?',
            ['B']);

        //update capital account
        DB::update(
            'update balance' . $rdate . $request->user . ' a join acctgroups as b on a.group_id=b.group_id set a.bal = a.credit-a.debit where b.grouptype = ?',
            ['C']);

        

        

        //-------------------------------------------------
       //Updating item Net Income for Capital
       //-------------------------------------------------
     


        $income = DB::table('income' . $rdate . $request->user)
        ->join('acctgroups','income' . $rdate . $request->user . '.group_id','=','acctgroups.group_id')
        ->where('acctgroups.grouptype','D')
        ->sum('income' . $rdate . $request->user . '.bal');
        // print_r($income);
        

        $expense = DB::table('income' . $rdate . $request->user)
        ->join('acctgroups','income' . $rdate . $request->user . '.group_id','=','acctgroups.group_id')
        ->where('acctgroups.grouptype','E')
        ->sum('income' . $rdate . $request->user . '.bal');
        // print_r($expense);

       $netincome = $income - $expense;

       DB::update(
        'update balance' . $rdate . $request->user . ' set bal = ' . $netincome . ' where item_name = "NET INCOME" ');

       
        
       //-------------------------------------------------
       //Updating Account Net Income
       //-------------------------------------------------

        
        $balance = DB::table('balance' . $rdate . $request->user)
        ->select('balance' . $rdate . $request->user . '.*')
          ->get();

        //refresh temp table income
       $dropTempTables = DB::statement('DROP TABLE IF EXISTS income' . $rdate . $request->user );

        //refresh temp table balance sheet
        $dropTempTables = DB::statement('DROP TABLE IF EXISTS balance' . $rdate . $request->user );

        return response()->json($balance);

    }
}
