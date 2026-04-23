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
    Schema::create('admins', function (Blueprint $table) {
        $table->id('admin_id');
        $table->string('username')->unique();
        $table->string('password');
        $table->enum('role',['super_admin','admin'])->default('admin');
        $table->unsignedBigInteger('member_id')->nullable();
        $table->timestamps();

        $table->foreign('member_id')
              ->references('member_id')
              ->on('members')
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
