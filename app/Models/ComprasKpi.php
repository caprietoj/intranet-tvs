<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasKpi extends Model
{
    use HasFactory;

    protected $table = 'kpis';

    protected $fillable = [
        'threshold_id',
        'area',
        'name',
        'methodology',
        'frequency',
        'measurement_date',
        'percentage',
    ];

    public function threshold()
    {
        return $this->belongsTo(ComprasThreshold::class, 'threshold_id');
    }

    // Accesor que devuelve el estado basado en el threshold configurado
    public function getStatusAttribute()
    {
        $thresholdValue = $this->threshold ? $this->threshold->value : 80;
        return ($this->percentage >= $thresholdValue) ? 'Alcanzado' : 'No Alcanzado';
    }
}
