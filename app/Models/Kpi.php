<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'threshold_id',
        'area',
        'name',
        'methodology',
        'frequency',
        'measurement_date',
        'percentage',
    ];

    // Relación con el threshold
    public function threshold()
    {
        return $this->belongsTo(Threshold::class);
    }

    // Accesor para determinar el estado del KPI en función del umbral configurado
    public function getStatusAttribute()
    {
        // Si existe un threshold, se usa su valor, de lo contrario se asume 80%
        $threshold_value = $this->threshold ? $this->threshold->value : 80;
        return ($this->percentage >= $threshold_value) ? 'Alcanzado' : 'No Alcanzado';
    }
}
