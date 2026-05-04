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
        Schema::create('stmp_tag_kanban_fukuis', function (Blueprint $table) {
            $table->id();
            $table->string('doc_no')->nullable();
            $table->string('line_id');
            $table->string('item_id');
            $table->string('job_no')->nullable();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('model')->nullable();
            $table->string('name_material')->nullable();
            $table->integer('qty_ok')->nullable();
            $table->integer('qty_ng')->nullable();
            $table->date('date_plan')->nullable();
            $table->string('createdby')->nullable();
            $table->string('updateby')->nullable();
            $table->timestamps();
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->integer('no')->nullable();
            $table->string('shift')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('line')->nullable();
            $table->string('kode_material');
            $table->string('keterangan')->nullable();
            $table->string('line_stmp')->nullable();
            $table->string('sts')->nullable();
            $table->integer('sts_scan')->nullable();
            $table->string('sts_user')->nullable();
            $table->date('sts_time')->nullable();
            $table->string('part_no_rm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stmp_tag_kanban_fukuis');
    }
};
