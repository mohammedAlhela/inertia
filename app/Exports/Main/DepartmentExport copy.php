<?php

namespace App\Exports\Main;

use App\Http\Resources\Main\DepartmentsResource;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class DepartmentExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    public $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return collect(DepartmentsResource::collection(Department::whereIn('id', $this->ids)->orderBy('created_at', 'DESC')->with(['courses', 'subjects'])->get()));
    }

    public function headings(): array
    {
        return [
            'Addmission',
            'Name',
            'Courses',
            'Subjects',
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
