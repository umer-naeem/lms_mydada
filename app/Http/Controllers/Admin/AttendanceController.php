<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'course', 'approver'])
            ->orderByDesc('attendance_date')
            ->orderByDesc('id');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        if ($request->filled('user_search')) {
            $search = trim($request->user_search);
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('attendance_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('attendance_date', '<=', $request->date_to);
        }

        $data['title'] = 'Attendance';
        $data['attendances'] = $query->paginate(25)->withQueryString();
        $data['students'] = Student::approved()->with('user')->orderBy('first_name')->get();
        $data['instructors'] = Instructor::with('user')->orderBy('first_name')->get();

        return view('admin.attendance.index', $data);
    }

    public function create(Request $request)
    {
        $data['title'] = 'Create Attendance';
        $data['students'] = Student::approved()->with('user')->orderBy('first_name')->get();
        $data['instructors'] = Instructor::with('user')->orderBy('first_name')->get();
        $data['courses'] = Course::orderBy('title')->get();
        $data['role'] = $request->get('role', 'student');

        return view('admin.attendance.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:student,teacher',
            'user_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
            'attendance_date' => 'required|date',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,early_leave,late_early_leave',
            'late_minutes' => 'nullable|integer|min:0',
            'early_leave_minutes' => 'nullable|integer|min:0',
            'absence_reason' => 'nullable|string',
            'approval_status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $attendance = Attendance::create([
            'user_id' => $request->user_id,
            'role' => $request->role,
            'course_id' => $request->course_id,
            'attendance_date' => $request->attendance_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'status' => $request->status,
            'late_minutes' => $request->late_minutes ?? 0,
            'early_leave_minutes' => $request->early_leave_minutes ?? 0,
            'absence_reason' => $request->absence_reason,
            'approval_status' => $request->approval_status,
            'created_by' => Auth::id(),
            'notes' => $request->notes,
        ]);

        if ($attendance->approval_status === 'approved') {
            $attendance->approved_by = Auth::id();
            $attendance->approved_at = now();
            $attendance->save();
        }

        return redirect()->route('admin.attendance.index')->with('success', __('Attendance saved.'));
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Attendance';
        $data['attendance'] = Attendance::findOrFail($id);
        $data['students'] = Student::approved()->with('user')->orderBy('first_name')->get();
        $data['instructors'] = Instructor::with('user')->orderBy('first_name')->get();
        $data['courses'] = Course::orderBy('title')->get();

        return view('admin.attendance.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $request->validate([
            'role' => 'required|in:student,teacher',
            'user_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id',
            'attendance_date' => 'required|date',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,late,early_leave,late_early_leave',
            'late_minutes' => 'nullable|integer|min:0',
            'early_leave_minutes' => 'nullable|integer|min:0',
            'absence_reason' => 'nullable|string',
            'approval_status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $attendance->fill([
            'user_id' => $request->user_id,
            'role' => $request->role,
            'course_id' => $request->course_id,
            'attendance_date' => $request->attendance_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'status' => $request->status,
            'late_minutes' => $request->late_minutes ?? 0,
            'early_leave_minutes' => $request->early_leave_minutes ?? 0,
            'absence_reason' => $request->absence_reason,
            'approval_status' => $request->approval_status,
            'notes' => $request->notes,
        ]);

        if ($request->approval_status === 'approved' && !$attendance->approved_at) {
            $attendance->approved_by = Auth::id();
            $attendance->approved_at = now();
        }

        if ($request->approval_status !== 'approved') {
            $attendance->approved_by = null;
            $attendance->approved_at = null;
        }

        $attendance->save();

        return redirect()->route('admin.attendance.index')->with('success', __('Attendance updated.'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'approval_status' => 'required|in:approved,rejected',
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->approval_status = $request->approval_status;
        $attendance->approved_by = Auth::id();
        $attendance->approved_at = now();
        $attendance->save();

        return redirect()->back()->with('success', __('Attendance approval updated.'));
    }

    public function monthly(Request $request)
    {
        $request->validate([
            'role' => 'required|in:student,teacher',
            'user_id' => 'required|exists:users,id',
            'month' => 'required|date_format:Y-m',
        ]);

        $month = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();

        $attendanceByDate = Attendance::where('user_id', $request->user_id)
            ->where('role', $request->role)
            ->whereBetween('attendance_date', [$start, $end])
            ->get()
            ->keyBy(function ($attendance) {
                return $attendance->attendance_date->format('Y-m-d');
            });

        $data['title'] = 'Monthly Attendance Sheet';
        $data['month'] = $month;
        $data['user'] = $request->role === 'teacher'
            ? Instructor::with('user')->where('user_id', $request->user_id)->first()
            : Student::with('user')->where('user_id', $request->user_id)->first();
        $data['role'] = $request->role;
        $data['attendanceByDate'] = $attendanceByDate;
        $data['dates'] = collect(range(1, $month->daysInMonth))->map(function ($day) use ($month) {
            return $month->copy()->day($day);
        });

        return view('admin.attendance.monthly', $data);
    }

    public function monthlyForm()
    {
        $data['title'] = 'Monthly Attendance Sheet';
        $data['students'] = Student::approved()->with('user')->orderBy('first_name')->get();
        $data['instructors'] = Instructor::with('user')->orderBy('first_name')->get();

        return view('admin.attendance.monthly_form', $data);
    }

    public function exportExcel(Request $request)
    {
        $records = $this->filteredRecords($request)->get();

        return Excel::download(new AttendanceExport($records), 'attendance.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $records = $this->filteredRecords($request)->get();

        $pdf = Pdf::loadView('admin.attendance.export_pdf', [
            'attendances' => $records,
        ]);

        return $pdf->download('attendance.pdf');
    }

    private function filteredRecords(Request $request)
    {
        $query = Attendance::with(['user', 'course', 'approver'])
            ->orderByDesc('attendance_date')
            ->orderByDesc('id');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        if ($request->filled('user_search')) {
            $search = trim($request->user_search);
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('attendance_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('attendance_date', '<=', $request->date_to);
        }

        return $query;
    }
}

