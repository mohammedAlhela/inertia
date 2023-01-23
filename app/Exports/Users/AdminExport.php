<?php

namespace App\Exports\Users;

use App\Http\Resources\Users\AdminsExportResource;
use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    public $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return collect(AdminsExportResource::collection(Admin::whereIn('id', $this->ids)->orderBy('created_at', 'DESC')->with('user')->get()));
    }

    public function headings(): array
    {
        return [
            'Addmission',
            'email',
            'Username',
            'first_name',
            'last_name',
            'gender',
            'Birth date',
            'Address',
            'status',
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
