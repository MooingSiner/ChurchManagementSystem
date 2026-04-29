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
    Schema::create('members', function (Blueprint $table) {
        $table->id('member_id');
        $table->string('member_fname');
        $table->string('member_mname')->nullable();
        $table->string('member_lname');
        $table->string('gender');
        $table->date('birth_date');
        $table->string('email')->unique();
        $table->string('phone_number')->unique();
        $table->string('province');
        $table->string('city');
        $table->string('street')->nullable();
        $table->boolean('is_archived')->default(false);
        $table->timestamp('archived_at')->nullable();
        $table->timestamps();
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
