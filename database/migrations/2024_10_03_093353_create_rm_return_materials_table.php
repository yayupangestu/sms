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

            Schema::create('rm_return_materials', function (Blueprint $table) {
                $table->id();
                $table->string('unoqNo');
                $table->string('name_material');
                $table->string('part_no');
                $table->string('suplier')->nullable();
                $table->string('qty_awal')->nullable();
                $table->string('material_id')->nullable();
                $table->string('no')->nullable();
                $table->string('createdby')->nullable();
                $table->string('updatedby')->nullable();
                $table->timestamps();
            });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_return_materials');
    }
};
