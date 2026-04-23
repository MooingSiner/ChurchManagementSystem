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
    Schema::create('address', function (Blueprint $table) {
        $table->id('address_id');
        $table->string('province');
        $table->string('city');
        $table->string('street')->nullable();
        $table->unsignedBigInteger('member_id')->unique();
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
