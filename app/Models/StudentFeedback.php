<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeedback extends Model
{
    use HasFactory;

    protected $table = 'student_feedbacks';

    protected $fillable = [
        'student_id',
        'course_id',
        'feedback_date',
        'rating',
        'notes',
    ];

    protected $casts = [
        'feedback_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

