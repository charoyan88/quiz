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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->unsignedFloat('point')->nullable();
            $table->integer('time_total')->nullable();
            $table->integer('time_limit')->nullable();
            $table->integer('point_percent')->nullable();
            $table->unsignedFloat('minimal_point')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
