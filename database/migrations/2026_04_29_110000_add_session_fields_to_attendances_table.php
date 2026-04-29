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
        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->index('member_id', 'attendances_member_id_index');
            } catch (Throwable $e) {
                //
            }

            try {
                $table->index('event_id', 'attendances_event_id_index');
            } catch (Throwable $e) {
                //
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->dropUnique(['member_id', 'event_id']);
            } catch (Throwable $e) {
                //
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'attendance_session_id')) {
                $table->unsignedBigInteger('attendance_session_id')->nullable()->after('admin_id');
            }

            if (!Schema::hasColumn('attendances', 'time_in')) {
                $table->timestamp('time_in')->nullable()->after('attended_at');
            }

            if (!Schema::hasColumn('attendances', 'time_out')) {
                $table->timestamp('time_out')->nullable()->after('time_in');
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->foreign('attendance_session_id')
                    ->references('attendance_session_id')
                    ->on('attendance_sessions')
                    ->onDelete('cascade');
            } catch (Throwable $e) {
                //
            }

            try {
                $table->unique(['member_id', 'attendance_session_id']);
            } catch (Throwable $e) {
                //
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->dropUnique(['member_id', 'attendance_session_id']);
            } catch (Throwable $e) {
                //
            }

            try {
                $table->dropForeign(['attendance_session_id']);
            } catch (Throwable $e) {
                //
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'time_out')) {
                $table->dropColumn('time_out');
            }

            if (Schema::hasColumn('attendances', 'time_in')) {
                $table->dropColumn('time_in');
            }

            if (Schema::hasColumn('attendances', 'attendance_session_id')) {
                $table->dropColumn('attendance_session_id');
            }
        });

        Schema::table('attendances', function (Blueprint $table) {
            try {
                $table->unique(['member_id', 'event_id']);
            } catch (Throwable $e) {
                //
            }
        });
    }
};
