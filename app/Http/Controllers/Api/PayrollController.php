<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PayrollController extends Controller
{
    public function Pay(Request $request, $id){
        $validateData = $request->validate([
            'salary_month' =>'required',
        ]);

        $month = $request->salary_month;
        $check = DB::table('payroll')->where('employee_id',$id)->where('salary_month',$month)->first();
        if ($check) {
            return response()->json('Salary Already Paid');
        }else{
            $data = array();
            $data['employee_id'] = $id;
            $data['amount'] = $request->salary;
            $data['salary_date'] = date('d/m/Y');
            $data['salary_month'] = $month;
            $data['salary_year'] = date('Y');
            DB::table('payroll')->insert($data);
        }
    }

    public function AllPay(){
        $payroll = DB::table('payroll')->select('salary_month')->groupBy('salary_month')->get();
        return response()->json($payroll);	
    }

    public function ViewPayroll($id){

        $month = $id;
          $view = DB::table('payroll')
                  ->join('employees','payroll.employee_id','employees.id')
                  ->select('employees.name','payroll.*')
                  ->where('payroll.salary_month',$month)
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


}
