<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLevelHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'level',
        'notes',
        'promoted_by',
        'promoted_at',
    ];

    protected $casts = [
        'promoted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function promoter()
    {
        return $this->belongsTo(User::class, 'promoted_by');
    }
}

