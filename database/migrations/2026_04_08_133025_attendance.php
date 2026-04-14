<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id('attendance_id');
        $table->unsignedBigInteger('member_id');
        $table->unsignedBigInteger('event_id');
        $table->unsignedBigInteger('admin_id');
        $table->date('date_attended');
        $table->time('time_attended');
        $table->string('status');

        $table->foreign('member_id')
              ->references('member_id')
              ->on('members')
              ->onDelete('cascade');

        $table->foreign('event_id')
              ->references('event_id')
              ->on('events')
              ->onDelete('cascade');

        $table->foreign('admin_id')
              ->references('admin_id')
              ->on('admins')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
