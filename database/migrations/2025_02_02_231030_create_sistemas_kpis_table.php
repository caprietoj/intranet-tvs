<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSistemasKpisTable extends Migration
{
    public function up()
    {
        Schema::create('sistemas_kpis', function (Blueprint $table) {
            $table->id();
            // Clave foránea a la tabla sistemas_thresholds
            $table->foreignId('threshold_id')->constrained('sistemas_thresholds')->onDelete('cascade');
            $table->string('name');                // Nombre del KPI (derivado del threshold)
            $table->string('methodology');         // Metodología de medición (input text)
            $table->string('frequency');           // Frecuencia de medición (Diario, Quincenal, Mensual)
            $table->date('measurement_date');      // Fecha de medición
            $table->decimal('percentage', 5, 2);    // Porcentaje alcanzado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sistemas_kpis');
    }
}
