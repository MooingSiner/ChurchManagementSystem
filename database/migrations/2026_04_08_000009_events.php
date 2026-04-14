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
    Schema::create('events', function (Blueprint $table) {
        $table->id('event_id');
        $table->string('event_name');
        $table->date('start_date');
        $table->date('end_date');
        $table->time('start_time');
        $table->time('end_time');
        $table->text('description')->nullable();
        $table->unsignedBigInteger('type_id');
        $table->unsignedBigInteger('admin_id');

        $table->foreign('type_id')
              ->references('type_id')
              ->on('types')
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
