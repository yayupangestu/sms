<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrScansTable extends Migration
{
    public function up()
    {
        Schema::create('qr_scans', function (Blueprint $table) {
            $table->id();
            $table->string('scanned_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('qr_scans');
    }
}

