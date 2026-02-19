<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'students';
    protected $fillable = [
        'user_id',
        'country_id',
        'province_id',
        'state_id',
        'city_id',
        'student_id',
        'roll_no',
        'current_level',
        'admission_date',
        'first_name',
        'last_name',
        'phone_number',
        'postal_code',
        'address',
        'about_me',
        'gender',
        'status',
        'account_frozen',
        'frozen_at',
        'organization_id',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'account_frozen' => 'boolean',
        'frozen_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function levelHistories()
    {
        return $this->hasMany(StudentLevelHistory::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(StudentLeaveRequest::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(StudentFeedback::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getNameAttribute()
    {
        return $this->first_name .' '. $this->last_name;
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }


    public static function generateAdvancedRollNumber($request = null)
    {
        $currentDate = now();
        $month = strtoupper($currentDate->format('M')); // FEB
        $year = $currentDate->format('Y'); // 2026
        $day = $currentDate->format('d'); // 16

        // Current month me kitne students add hue (monthly sequence)
        $count = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $currentDate->month)
            ->count();

        // Sequence 3 digits (001 se start)
        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Final roll number: FEB202616001
        $roll_no = $month . $year . $day . $sequence;

        return $roll_no;
    }


    /**
     * Alternative: Month number ke sath
     */
    public static function generateRollNumberWithMonthNumber($request = null)
    {
        $currentDate = now();
        $year = $currentDate->format('Y');
        $month = $currentDate->format('m'); // 02 for February
        $day = $currentDate->format('d'); // 16

        $admissionYear = $request && $request->admission_date
            ? date('Y', strtotime($request->admission_date))
            : $year;

        // Extract numeric part from current level
        $levelCode = '';
        if ($request && $request->current_level) {
            preg_match('/\d+/', $request->current_level, $matches);
            $levelCode = isset($matches[0]) ? $matches[0] : '';
        }

        $count = self::whereYear('admission_date', $admissionYear)->count();
        $sequence = str_pad($count + 1, 5, '0', STR_PAD_LEFT);

        if ($levelCode) {
            // Format: YEAR + MONTH_NUMBER + DAY + LEVELCODE + SEQUENCE
            // Example: 202602162600001 (16 Feb 2026, level 26)
            $roll_no = $year . $month . $day . $levelCode . $sequence;
        } else {
            // Format: YEAR + MONTH_NUMBER + DAY + SEQUENCE
            // Example: 2026021600001
            $roll_no = $year . $month . $day . $sequence;
        }

        return $roll_no;
    }

    /**
     * Month name complete (February) ke sath
     */
    public static function generateRollNumberWithFullMonth($request = null)
    {
        $currentDate = now();
        $year = $currentDate->format('Y');
        $month = $currentDate->format('F'); // February (full month name)
        $day = $currentDate->format('d'); // 16

        $admissionYear = $request && $request->admission_date
            ? date('Y', strtotime($request->admission_date))
            : $year;

        $levelCode = '';
        if ($request && $request->current_level) {
            preg_match('/\d+/', $request->current_level, $matches);
            $levelCode = isset($matches[0]) ? $matches[0] : '';
        }

        $count = self::whereYear('admission_date', $admissionYear)->count();
        $sequence = str_pad($count + 1, 5, '0', STR_PAD_LEFT);

        if ($levelCode) {
            // Example: 2026February162600001
            $roll_no = $year . $month . $day . $levelCode . $sequence;
        } else {
            // Example: 2026February1600001
            $roll_no = $year . $month . $day . $sequence;
        }

        return $roll_no;
    }

    // ============ ROLL NUMBER AUTO-GENERATION CODE START ============

    /**
     * Advanced Roll Number Generate Method
     * Format: YEAR-LEVELCODE-SEQUENCE (Example: 2024-10-00001)
     */


    /**
     * Simple roll number generator (YEAR + MONTH + SEQUENCE)
     * Format: 20240200001 (Feb 2024 ka pehla student)
     */
    public static function generateSimpleRollNumber()
    {
        $year = date('Y');
        $month = date('m');

        $count = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();

        return $year . $month . str_pad($count + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get formatted roll number for display
     */
    public function getFormattedRollNoAttribute()
    {
        if ($this->roll_no) {
            // If roll number has hyphens, keep as is
            if (strpos($this->roll_no, '-') !== false) {
                return $this->roll_no;
            }
            // If it's YYYYMMNNNNN format, convert to YYYY-MM-NNNNN
            if (strlen($this->roll_no) >= 9) {
                $year = substr($this->roll_no, 0, 4);
                $month = substr($this->roll_no, 4, 2);
                $number = substr($this->roll_no, 6);
                return $year . '-' . $month . '-' . $number;
            }
        }
        return $this->roll_no ?? 'Not Assigned';
    }

    /**
     * Check if roll number exists
     */
    public static function rollNoExists($rollNo)
    {
        return self::where('roll_no', $rollNo)->exists();
    }

    // ============ ROLL NUMBER AUTO-GENERATION CODE END ============

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });

        // Agar roll number empty ho to auto-generate karo
        self::saving(function($model) {
            if (empty($model->roll_no)) {
                // Yaha request object nahi milega, isliye simple generator use karo
                // ya phir controller me generate karo
            }
        });
    }
}