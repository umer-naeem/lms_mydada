<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'course_id',
        'attendance_date',
        'check_in_time',
        'check_out_time',
        'status',
        'late_minutes',
        'early_leave_minutes',
        'absence_reason',
        'approval_status',
        'approved_by',
        'approved_at',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

