<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContabilidadKpisTable extends Migration
{
    public function up()
    {
        Schema::create('contabilidad_kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('threshold_id')
                  ->constrained('contabilidad_thresholds')
                  ->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['measurement', 'informative'])
                  ->default('measurement');
            $table->text('methodology');
            $table->enum('frequency', ['Diario', 'Quincenal', 'Mensual', 'Semestral']);
            $table->date('measurement_date');
            $table->decimal('percentage', 5, 2);
            $table->string('area')->default('contabilidad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contabilidad_kpis');
    }
}