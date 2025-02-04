<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpisTable extends Migration
{
    public function up()
    {
        Schema::create('kpis', function (Blueprint $table) {
            $table->id();
            // Relación con el threshold seleccionado (puede ser nulo si se elimina la configuración)
            $table->foreignId('threshold_id')->nullable()->constrained()->onDelete('set null');
            // (Opcional) Guardar el área para facilitar reportes
            $table->string('area')->nullable();
            // El nombre del KPI se asigna a partir del threshold configurado
            $table->string('name');
            // La metodología se ingresará mediante un input text
            $table->string('methodology');
            // La frecuencia se registrará mediante un select (Diario, Quincenal, Mensual)
            $table->string('frequency');
            $table->date('measurement_date');
            $table->decimal('percentage', 5, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kpis');
    }
}
