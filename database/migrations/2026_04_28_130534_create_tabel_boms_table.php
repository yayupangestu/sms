<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tabel_boms', function (Blueprint $table) {
            $table->id();
            $table->string('part_name')->nullable();
            $table->string('part_name2')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('job_no')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('model_id')->nullable();
            $table->string('updateby')->nullable();
            $table->string('createdby')->nullable();
            $table->string('category_id')->nullable();
            $table->string('vendor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_boms');
    }
};
