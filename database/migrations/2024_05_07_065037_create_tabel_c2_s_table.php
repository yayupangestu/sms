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
        Schema::create('tabel_c2_s', function (Blueprint $table) {
            $table->id();
            $table->string('job_no');
            $table->string('part_no');
            $table->string('model_id');
            $table->string('spec_id');
            $table->string('type_id');
            $table->string('shop_id');
            $table->string('createdby')->nullable();
            $table->string('updateby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_c2_s');
    }
};
