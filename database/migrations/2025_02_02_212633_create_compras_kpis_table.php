<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasKpisTable extends Migration
{
    public function up()
    {
        Schema::create('compras_kpis', function (Blueprint $table) {
            $table->id();
            // Se establece una clave foránea que referencia a la tabla de thresholds de Compras
            $table->foreignId('threshold_id')->constrained('compras_thresholds')->onDelete('cascade');
            $table->string('name');                // Nombre del KPI, que se asigna a partir del threshold
            $table->string('methodology');         // Metodología de medición (input de tipo text)
            $table->string('frequency');           // Frecuencia de medición (select: Diario, Quincenal, Mensual)
            $table->date('measurement_date');      // Fecha de medición
            $table->decimal('percentage', 5, 2);    // Porcentaje alcanzado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras_kpis');
    }
}
