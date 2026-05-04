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
        Schema::create('rm_monthlies', function (Blueprint $table) {
            $table->id();
            $table->date('date_day')->nullable();
            $table->string('month')->nullable();
            $table->string('day')->nullable();
            $table->string('plan_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_monthlies');
    }
};
