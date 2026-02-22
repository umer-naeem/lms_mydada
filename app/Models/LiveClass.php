<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'class_topic',
        'date',
        'time',
        'duration',
        'join_url',
        'start_url',
        'meeting_id',
        'meeting_host_name',
        'moderator_pw',
        'attendee_pw',
        'recording_url',
        'recording_available',
        'recording_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
            $model->user_id =  auth()->id();
        });
    }
}
