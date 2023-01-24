<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Exports\Main\AcademicYearExport;
use App\Http\Requests\Main\AcademicYearRequest;
use App\Models\AcademicYear;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class AcademicYearController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return inertia('App/Main/AcademicYears/Index', [
            'academicYears' => AcademicYear::all(),
        ]);

    }

    public function create()
    {
        return inertia('App/Main/AcademicYears/Create');
    }

    public function store(AcademicYearRequest $request)
    {

        AcademicYear::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/AcademicYears/Edit', [
            'academicYear' => AcademicYear::find($id),
        ]);

    }

    public function update(AcademicYearRequest $request, $id)
    {

        AcademicYear::update($request->except('created_at', 'updated_at'))->where('id', $id);
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $academicYears = AcademicYear::with('academicTerms')->whereIn('id', $ids)->get();

        foreach ($academicYears as $academicYear) {
            $academicYear->academicTerms->delete();
            $academicYear->delete();
        }

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $academicYears = AcademicYear::with('academicTerms')->whereIn('id', $ids)->get();

        $data = array(
            'academicYears' => $academicYears,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.academicYears.pdf', array('data' => $data));
        return $pdf->download('academicYears.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new AcademicYearExport($ids), 'academicYears.xlsx');
    }

}
