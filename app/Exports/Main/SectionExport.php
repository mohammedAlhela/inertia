<?php

namespace App\Exports\Main;

use App\Http\Resources\Main\AcademicYearsResource;
use App\Models\AcademicYear;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AcademicYearExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    public $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return collect(AcademicYearsResource::collection(AcademicYear::whereIn('id', $this->ids)->orderBy('created_at', 'DESC')->with('academicTerms')->get()));
    }

    public function headings(): array
    {
        return [
            'Addmission',
            'Name',
            'Start date',
            'End date',
            'Academic terms',
        ];
    }

    // ...

    /**
     * @return array
     */
    public function registerEvents(): array

    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont('arial')->setSize(16);
            },

        ];
    }
}
