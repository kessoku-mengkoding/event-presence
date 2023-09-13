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
        Schema::create('presences', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('groupmember_id');
            $table->uuid('timetable_id');
            $table->string('status');
            $table->boolean('is_valid');
            $table->timestamps();

            $table->foreign('groupmember_id')->references('id')->on('groupmembers')->onDelete('cascade');
            $table->foreign('timetable_id')->references('id')->on('timetables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
