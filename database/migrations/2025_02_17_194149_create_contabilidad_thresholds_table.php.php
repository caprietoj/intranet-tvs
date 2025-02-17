<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContabilidadThresholdsTable extends Migration
{
    public function up()
    {
        Schema::create('contabilidad_thresholds', function (Blueprint $table) {
            $table->id();
            $table->string('kpi_name');
            $table->integer('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contabilidad_thresholds');
    }
}