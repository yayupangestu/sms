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
        Schema::create('tabel_stok_blanks', function (Blueprint $table) {
            $table->id();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('job_no')->nullable();
            $table->string('model')->nullable();
            $table->string('spek')->nullable();
            $table->string('spek_t')->nullable();
            $table->string('spek_w')->nullable();
            $table->string('spek_l')->nullable();
            $table->string('spek_bq')->nullable();
            $table->string('spek_kg')->nullable();
            $table->string('packing')->nullable();
            $table->string('supplier')->nullable();
            $table->string('qty_min')->nullable();
            $table->string('minimal_kg')->nullable();
            $table->string('qty_actual')->nullable();
            $table->string('qty_kanban')->nullable();
            $table->string('no_rak')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('createdby')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('updatedby')->nullable();
            $table->string('sts')->nullable();
            $table->string('category')->nullable();
            $table->integer('home_line')->nullable();
            $table->string('line_proses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabel_stok_blanks');
    }
};
