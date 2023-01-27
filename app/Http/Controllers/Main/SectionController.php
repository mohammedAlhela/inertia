<?php

namespace App\Http\Controllers\Main;

use App\Exports\Main\SectionExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Main\SectionRequest;
use App\Models\Section;
use Excel;
use Helper;
use Illuminate\Http\Request;
use PdfReport;

class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $records = Section::with(['course'])->get();

        foreach ($records as $record) {

            $record->select = false;
        }

        return inertia('App/Main/Sections/Index', [
            'records' => $records,
        ]);

    }

    public function create()
    {
        return inertia('App/Main/Sections/Create');
    }

    public function store(SectionRequest $request)
    {

        Section::create($request->except('created_at', 'updated_at'));

    }

    public function edit($id)
    {

        return inertia('App/Main/Sections/Edit', [
            'Section' => Section::find($id),
        ]);

    }

    public function update(SectionRequest $request, $id)
    {

        Section::where('id', $id)->update($request->except('created_at', 'updated_at'));
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $Sections = Section::whereIn('id', $ids)->delete();

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $Sections = Section::with(['course'])->whereIn('id', $ids)->get();

        $data = array(
            'Sections' => $Sections,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('main.sections.pdf', array('data' => $data));
        return $pdf->download('sections.pdf');

    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new SectionExport($ids), 'sections.xlsx');
    }

}
