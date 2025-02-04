<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemasKpi extends Model
{
    use HasFactory;

    protected $table = 'sistemas_kpis';

    protected $fillable = [
        'threshold_id',
        'name',
        'methodology',
        'frequency',
        'measurement_date',
        'percentage',
    ];

    public function threshold()
    {
        return $this->belongsTo(SistemasThreshold::class, 'threshold_id');
    }

    // Accesor para determinar el estado basado en el umbral configurado
    public function getStatusAttribute()
    {
        $thresholdValue = $this->threshold ? $this->threshold->value : 80;
        return ($this->percentage >= $thresholdValue) ? 'Alcanzado' : 'No Alcanzado';
    }
}
