<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_id')->nullable()->unique()->after('organization_id');
            $table->string('roll_no')->nullable()->after('student_id');
            $table->string('current_level')->nullable()->after('roll_no');
            $table->date('admission_date')->nullable()->after('current_level');
            $table->boolean('account_frozen')->default(false)->after('status');
            $table->timestamp('frozen_at')->nullable()->after('account_frozen');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'student_id',
                'roll_no',
                'current_level',
                'admission_date',
                'account_frozen',
                'frozen_at',
            ]);
        });
    }
};

