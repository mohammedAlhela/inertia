<?php

namespace App\Http\Controllers;

// use App\Exports\DeductionExport;
// use App\Models\Deduction;
// use App\Models\Employee;
// use Excel;
// use Helper;
// use Illuminate\Http\Request;

class DeductionController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

        // $this->middleware('activeUser');

    }


    // public function write(Request $request)
    // {

    //     $authArray = array('deduction', 'write');

    //     Helper::authorizeModel($authArray);

    //     $id = $request->id;

    //     $deduction = $id ? Deduction::where('id' , $id)->update($request->except('manage')) :  Deduction::create($request->except('manage'));

    //     $record = $id ? Deduction::find($id) : $deduction;

    //     $record->code =  "DED-$record->employee_id-$record->id" ;

    //     $record->save();

    // }

    public function index()
    {

        // $authArray = array('deduction', 'show');

        // Helper::authorizeModel($authArray);

        return inertia('Deductions');

    }

    // public function getData()
    // {

    //     $authArray = array('deduction', 'show');

    //     Helper::authorizeModel($authArray);

    //     $deductions = Deduction::all();

    //     $employees = Employee::all();

    //     $employeeTypes = Employee::distinct('employee_type')->pluck('employee_type');

    //     $basedAtPlaces = Employee::distinct('based_at')->pluck('based_at');

    //     $genders = Employee::distinct('gender')->pluck('gender');

    //     $positions = Employee::distinct('position')->pluck('position');

    //     $response = [
    //         'deductions' => $deductions,

    //         'employees' => $employees,

    //         'employeeTypes' => $employeeTypes,

    //         'basedAtPlaces' => $basedAtPlaces,

    //         'genders' => $genders,

    //         'positions' => $positions,

    //     ];

    //     return response($response, 201);

    // }

    // public function delete($id)
    // {

    //     $authArray = array('deduction', 'delete');

    //     Helper::authorizeModel($authArray);

    //     $deduction = Deduction::find($id)->delete();

    //     return $deduction;


    // }


    // public function exportExcel($id)
    // {

    //     $authArray = array('deduction', 'show');

    //     Helper::authorizeModel($authArray);

    //     return Excel::download(new DeductionExport($id), 'deductions.xlsx');

    // }

}
