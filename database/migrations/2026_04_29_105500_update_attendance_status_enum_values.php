<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE attendances MODIFY status VARCHAR(20) DEFAULT 'Pending'");

        DB::table('attendances')->where('status', 'pending')->update(['status' => 'Pending']);
        DB::table('attendances')->where('status', 'approved')->update(['status' => 'Present']);
        DB::table('attendances')->where('status', 'rejected')->update(['status' => 'Rejected']);

        DB::statement("ALTER TABLE attendances MODIFY status ENUM('Pending', 'Present', 'Rejected') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE attendances MODIFY status VARCHAR(20) DEFAULT 'pending'");

        DB::table('attendances')->where('status', 'Pending')->update(['status' => 'pending']);
        DB::table('attendances')->where('status', 'Present')->update(['status' => 'approved']);
        DB::table('attendances')->where('status', 'Rejected')->update(['status' => 'rejected']);

        DB::statement("ALTER TABLE attendances MODIFY status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
