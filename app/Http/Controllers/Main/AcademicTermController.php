<?php

namespace App\Http\Controllers\Main;

use App\Exports\Main\AcademicTermExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\AcademicTermRequest;
use App\Models\AcademicTerm;
use App\Models\AcademicYear;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class AcademicTermController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $records = AcademicTerm::with('academicYear')->get();

        foreach ($records as $record) {

            $record->select = false;
        }

        return inertia('App/Main/AcademicTerms/Index', [
            'academicTerms' => $records,
            'academicYears' => AcademicYear::all()
            
        ]);

    }

    public function create()
    {
        return inertia('App/Main/AcademicTerms/Create' , [
            'academicYears' => AcademicYear::all()
        ]);
    }

    public function store(AcademicTermRequest $request)
    {

        AcademicTerm::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/AcademicTerms/Edit', [
            'academicTerm' => AcademicTerm::find($id),
            'academicYears' => AcademicYear::all()
        ]);

    }

    public function update(AcademicTermRequest $request, $id)
    {

        AcademicTerm::where('id', $id)->update($request->except('created_at', 'updated_at'));
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $academicTerms = AcademicTerm::whereIn('id', $ids)->get();

        foreach ($academicTerms as $academicTerm) {
            $academicTerm->delete();
        }

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $academicTerms = AcademicTerm::with('academicYear')->whereIn('id', $ids)->get();

        $data = array(
            'academicTerms' => $academicTerms,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.academicTerms.pdf', array('data' => $data));
        return $pdf->download('academicTerms.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new AcademicTermExport($ids), 'academicTerms.xlsx');
    }

}
