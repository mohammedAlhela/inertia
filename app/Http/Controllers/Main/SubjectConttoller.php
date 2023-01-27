<?php

namespace App\Http\Controllers\Main;

use App\Exports\Main\SubjectExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\SubjectRequest;
use App\Models\Subject;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class SubjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $records = Subject::with(['course' , 'department'])->get();

        foreach ($records as $record) {

            $record->select = false;
        }

        return inertia('App/Main/Subjects/Index', [
            'Subjects' => $records,
        ]);

    }

    public function create()
    {
        return inertia('App/Main/Subjects/Create');
    }

    public function store(SubjectRequest $request)
    {

        Subject::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/Subjects/Edit', [
            'Subject' => Subject::find($id),
        ]);

    }

    public function update(SubjectRequest $request, $id)
    {

        Subject::where('id', $id)->update($request->except('created_at', 'updated_at'));
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $Subjects = Subject::whereIn('id', $ids)->delete();

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $Subjects = Subject::with(['course' , 'department'])->whereIn('id', $ids)->get();

        $data = array(
            'Subjects' => $Subjects,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.subjects.pdf', array('data' => $data));
        return $pdf->download('subjects.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new SubjectExport($ids), 'subjects.xlsx');
    }

}
