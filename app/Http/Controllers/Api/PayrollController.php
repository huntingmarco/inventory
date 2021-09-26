<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DateTime;

class PayrollController extends Controller
{
    public function Pay(Request $request, $id){
        $validateData = $request->validate([
            'pay_id' =>'required',
        ]);

        $settings = DB::table('settings')->first();
        $sysdate = $settings->sysdate;

        $pay_id = $request->pay_id;
        $check = DB::table('payroll')->where('employee_id',$id)->where('pay-id',$pay_id)->first();
        if ($check) {
            return response()->json('Salary Already Paid');
        }else{
            $mydate = DateTime::createFromFormat('Y-m-d', $sysdate)->format('ymd');
            $pid = IdGenerator::generate(['table' => 'payroll', 'length' => 12, 'prefix' => 'P' . $mydate]);
            $data = array();
            $data['id'] = $pid;
            $data['employee_id'] = $id;
            $data['amount'] = $request->salary;
            $data['pay_id'] = $request->pay_id;
            $data['user'] = $request->user;
            DB::table('payroll')->insert($data);

        }
    }

    public function AllPay(){
        //$payroll = DB::table('payroll')->select('salary_year','salary_month')->groupBy('salary_year','salary_month')->get();
        //return response()->json($payroll);	

        $pay = DB::table('pays')->select('id','payfrom','payto','status','transact_date')->get();
        return response()->json($pay);	
    }

    public function ViewPayroll($id){

        //$month = $id;
          $view = DB::table('payroll')
                  ->join('employees','payroll.employee_id','employees.id')
                  ->select('employees.name','payroll.*')
                  ->where('payroll.pay_id',$id)
                  ->get();
                  return response()->json($view);
    
      }

      public function EditPayroll($id){

        $view = DB::table('payroll')
                ->join('employees','payroll.employee_id','employees.id')
                ->select('employees.name','employees.email','payroll.*')
                ->where('payroll.id',$id)
                ->first();
                return response()->json($view);
  
    }

    public function UpdateSalary(Request $request,$id){

        $data = array();
        $data['employee_id'] = $request->employee_id;
        $data['amount'] = $request->amount;
        $data['salary_month'] = $request->salary_month;
        
      DB::table('payroll')->where('id',$id)->update($data);
    }

    public function TransactSalary(Request $request,$id){

        $payroll = DB::table('payroll')->where('pay_id',$id)->sum('amount');

         //get account code for payroll and  system date
         $settings = DB::table('settings')->first();
         $sysdate = $settings->sysdate;

        
        $group_id_cheque = $settings->group_id_cheque;
        $item_id_cheque = $settings->item_id_cheque;
        $group_id_pay = $settings->group_id_pay;
        $item_id_pay = $settings->item_id_pay;

       

        //store transaction for accounting - debit entry
        $mydate = DateTime::createFromFormat('Y-m-d', $sysdate)->format('ymd');
        $idtrn = IdGenerator::generate(['table' => 'trn', 'length' => 12, 'prefix' => 'T' .$mydate]);
        $data = array();
        $data['id'] = $idtrn;
        $data['details'] = 'payroll';
        $data['group_id'] = $group_id_cheque;
        $data['item_id'] = $item_id_cheque;
        $data['amount'] = $payroll;
        $data['entry'] = 'DR';
        $data['trn'] = 'PAYROLL';
        $data['ref'] = $id;
        $data['trndate'] = $sysdate;
        $data['user'] = $request->user;
        DB::table('trn')->insert($data);

        //store transaction for accounting - credit entry
        $mydate = DateTime::createFromFormat('Y-m-d', $sysdate)->format('ymd');
        $idtrn = IdGenerator::generate(['table' => 'trn', 'length' => 12, 'prefix' => 'T' . $mydate]);
        $data = array();
        $data['id'] = $idtrn;
        $data['details'] = 'payroll';
        $data['group_id'] = $group_id_pay;
        $data['item_id'] = $item_id_pay;
        $data['amount'] = $payroll;
        $data['entry'] = 'CR';
        $data['trn'] = 'PAYROLL';
        $data['ref'] = $id;
        $data['trndate'] = $sysdate;
        $data['user'] = $request->user;
        DB::table('trn')->insert($data);

        //update status
      
        DB::table('pays')->where('id',$id)->update(['status'=> 'PROCESSED','transact_date'=> $sysdate]);
    }


}
