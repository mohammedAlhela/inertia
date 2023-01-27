<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Exports\Main\DepartmentExport;
use App\Http\Requests\Main\DepartmentRequest;
use App\Models\Department;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class DepartmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $records = Department::with(['courses' , 'subjects'])->get();

        foreach ($records as $record) {

            $record->select = false;
        }


        return inertia('App/Main/Departments/Index', [
            'records' => $records
        ]);

    }

    public function create()
    {
        return inertia('App/Main/Departments/Create');
    }

    public function store(DepartmentRequest $request)
    {

        Department::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/Departments/Edit', [
            'record' => Department::find($id),
        ]);

    }

    public function update(DepartmentRequest $request, $id)
    {

        Department::where('id', $id)->update($request->except('created_at', 'updated_at'));
    }
    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $records = Department::whereIn('id', $ids)->delete();

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $records = Department::with(['courses' , 'subjects'])->whereIn('id', $ids)->get();

        $data = array(
            'records' => $records,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.departments.pdf', array('data' => $data));
        return $pdf->download('departments.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new DepartmentExport($ids), 'departments.xlsx');
    }

}
