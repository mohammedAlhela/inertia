<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use DB;
use Excel;
use Helper;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index()
    {

        $authArray = array('employee', 'show');

        Helper::authorizeModel($authArray);

        $employees = Employee::with(['deductions', 'expenses'])->orderBy('created_at', 'DESC')->get();

        $employeeTypes = Employee::distinct('employee_type')->pluck('employee_type');

        $basedAtPlaces = Employee::distinct('based_at')->pluck('based_at');

        $genders = Employee::distinct('gender')->pluck('gender');

        $nationalities = Employee::distinct('nationality')->pluck('nationality');

        $positions = Employee::distinct('position')->pluck('position');

        $positionBranchNumbers = Employee::distinct('position_branch_number')->pluck('position_branch_number');

        $basedAtCurrentStatus = Employee::distinct('based_at_current_status')->pluck('based_at_current_status');

        return inertia('Employees/Index', [
            'employees' => $employees,

            'employeeTypes' => $employeeTypes,

            'basedAtPlaces' => $basedAtPlaces,

            'genders' => $genders,

            'nationalities' => $nationalities,

            'positions' => $positions,

            'positionBranchNumbers' => $positionBranchNumbers,

            'basedAtCurrentStatus' => $basedAtCurrentStatus,
        ]);

    }

    public function create()
    {

        $authArray = array('employee', 'write');

        Helper::authorizeModel($authArray);

        return inertia('Employees/Create');

    }

    public function edit($id)
    {

        $authArray = array('employee', 'write');

        Helper::authorizeModel($authArray);

        $employeeTypes = Employee::distinct('employee_type')->pluck('employee_type');

        $basedAtPlaces = Employee::distinct('based_at')->pluck('based_at');

        $genders = Employee::distinct('gender')->pluck('gender');

        $nationalities = Employee::distinct('nationality')->pluck('nationality');

        $positions = Employee::distinct('position')->pluck('position');

        $positionBranchNumbers = Employee::distinct('position_branch_number')->pluck('position_branch_number');

        $basedAtCurrentStatus = Employee::distinct('based_at_current_status')->pluck('based_at_current_status');

        return inertia('Employees/Update', [
            'employee' => Employee::find($id),

            'employeeTypes' => $employeeTypes,

            'basedAtPlaces' => $basedAtPlaces,

            'genders' => $genders,

            'nationalities' => $nationalities,

            'positions' => $positions,

            'positionBranchNumbers' => $positionBranchNumbers,

            'basedAtCurrentStatus' => $basedAtCurrentStatus,
        ]);

    }

    public function write(EmployeeRequest $request)
    {

        $authArray = array('employee', 'write');

        Helper::authorizeModel($authArray);

        $id = $request->id;

        $employee = $id ? Employee::where('id', $id)->update($request->except('deductions', 'expenses', 'image', 'file')) : Employee::create($request->except('deductions', 'expenses', 'image', 'file'));

        $employeeRecord = $id ? Employee::find($id) : $employee;

        $image = request()->file("file");

        $data = array(
            "record" => $employeeRecord,
            "image" => $image,
            "dirPath" => "/images/employees/",
            "width" => 400,
            "height" => 400,

        );

        Helper::uploadImage($data);

    }

    public function delete($id)
    {

        $authArray = array('employee', 'delete');

        Helper::authorizeModel($authArray);

        $employee = Employee::find($id);

        if ($employee->image) {

            $imageFileExist = file_exists(public_path() . $employee->image);

            $imageFileExist ? $imageFileDeleted = unlink(substr($employee->image, 1)) : $imageFileDeleted = false;

            $imageFileExist ? ($imageFileDeleted ? $employee->delete() : 1 == 1) : $employee->delete();
        } else {
            $employee->delete();
        }

        DB::table('deductions')->where('employee_id', $id)->delete();

        DB::table('expenses')->where('employee_id', $id)->delete();

    }

    public function deleteImage($id)
    {

        $authArray = array('employee', 'write');

        Helper::authorizeModel($authArray);

        $employee = Employee::find($id);

        $imageFileExist = file_exists(public_path() . $employee->image);

        $imageFileExist ? $imageFileDeleted = unlink(substr($employee->image, 1)) : $imageFileDeleted = false;

        $imageFileExist ? ($imageFileDeleted ? Employee::where('id', $id)->update(['image' => null]) : 1 == 1) : Employee::where('id', $id)->update(['image' => null]);

    }

    public function exportExcel()
    {

        $authArray = array('employee', 'show');

        Helper::authorizeModel($authArray);

        return Excel::download(new EmployeeExport, 'employees.xlsx');

    }

}
