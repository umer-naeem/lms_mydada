<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    private Collection $records;

    public function __construct(Collection $records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        return $this->records;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Role',
            'User',
            'Course',
            'Status',
            'Check In',
            'Check Out',
            'Late Minutes',
            'Early Leave Minutes',
            'Absence Reason',
            'Approval Status',
            'Approved By',
        ];
    }

    public function map($attendance): array
    {
        return [
            optional($attendance->attendance_date)->format('Y-m-d'),
            $attendance->role,
            optional($attendance->user)->name,
            optional($attendance->course)->title,
            $attendance->status,
            $attendance->check_in_time,
            $attendance->check_out_time,
            $attendance->late_minutes,
            $attendance->early_leave_minutes,
            $attendance->absence_reason,
            $attendance->approval_status,
            optional($attendance->approver)->name,
        ];
    }
}

