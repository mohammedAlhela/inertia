<?php

namespace App\Exports\Users;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Http\Resources\UsersExportResource;

class AdminExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    protected $ids;

    public function __construct($ids)
    {
     $this->ids = $ids;
    }

    public function collection()
    {
        return Admin::whereIn('id' , $this->ids)->get();
    }

    public function headings(): array
    {
        return [
            'Addmission',
            'User',
            'Email',
            'Name',
            'Phone',
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
