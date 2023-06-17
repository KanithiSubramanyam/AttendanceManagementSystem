<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

   
class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendance::all();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Employee Id',
            'Attendace',
            'Reason',
            'Date',
            'Created At',
            'Deleted At'
        ];
    }
}