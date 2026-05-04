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
        Schema::create('upload_rekap_order_adm_p4_s', function (Blueprint $table) {
            $table->id();
            $table->string('doc_dn')->nullable();
            $table->string('proses')->nullable();
            $table->string('uniqNo')->nullable();
            $table->string('manifest')->nullable();
            $table->string('part_name')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_no2')->nullable();
            $table->string('job_no')->nullable();
            $table->integer('qty_kanban')->nullable();
            $table->integer('qty_order')->nullable();
            $table->integer('jml_kanban')->nullable();
            $table->integer('cycle')->nullable();
            $table->string('type_pallet')->nullable();
            $table->datetime('date_upload')->nullable();
            $table->string('route')->nullable();
            $table->string('route2')->nullable();
            $table->time('cycle_arrival')->nullable();
            $table->string('cycle_departure')->nullable();
            $table->integer('sts')->nullable();
            $table->timestamps();
            $table->datetime('createdby')->nullable();
            $table->date('del_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_rekap_order_adm_p4_s');
    }
};
