<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('live_classes', function (Blueprint $table) {
            $table->mediumText('recording_url')->nullable()->after('join_url')->comment('URL to the recording (Zoom Cloud, YouTube, Vimeo, etc.)');
            $table->boolean('recording_available')->default(0)->after('recording_url')->comment('Flag to indicate if recording is available');
            $table->string('recording_type')->nullable()->after('recording_available')->comment('Type of recording: zoom, youtube, vimeo, bbb, etc.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('live_classes', function (Blueprint $table) {
            $table->dropColumn(['recording_url', 'recording_available', 'recording_type']);
        });
    }
};
