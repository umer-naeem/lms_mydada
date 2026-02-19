<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h2>Attendance Report</h2>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Role</th>
            <th>User</th>
            <th>Course</th>
            <th>Status</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Late</th>
            <th>Early Leave</th>
            <th>Reason</th>
            <th>Approval</th>
        </tr>
        </thead>
        <tbody>
        @foreach($attendances as $attendance)
            <tr>
                <td>{{ optional($attendance->attendance_date)->format('Y-m-d') }}</td>
                <td>{{ $attendance->role }}</td>
                <td>{{ optional($attendance->user)->name }}</td>
                <td>{{ optional($attendance->course)->title }}</td>
                <td>{{ $attendance->status }}</td>
                <td>{{ $attendance->check_in_time }}</td>
                <td>{{ $attendance->check_out_time }}</td>
                <td>{{ $attendance->late_minutes }}</td>
                <td>{{ $attendance->early_leave_minutes }}</td>
                <td>{{ $attendance->absence_reason }}</td>
                <td>{{ $attendance->approval_status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>

