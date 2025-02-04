<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasThresholdsTable extends Migration
{
    public function up()
    {
        Schema::create('compras_thresholds', function (Blueprint $table) {
            $table->id();
            $table->string('kpi_name');              // Nombre del KPI configurado para Compras
            $table->decimal('value', 5, 2)->default(80.00); // Valor del umbral (por defecto 80%)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras_thresholds');
    }
}
