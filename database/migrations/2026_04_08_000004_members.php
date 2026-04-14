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
        $table->date('birth_date');
        $table->string('email')->unique();
        $table->string('phone_number');
        $table->unsignedBigInteger('address_id');

        $table->foreign('address_id')
              ->references('address_id')
              ->on('address')
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
