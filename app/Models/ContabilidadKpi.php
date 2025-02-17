<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContabilidadKpi extends Model
{
    use HasFactory;

    protected $fillable = [
        'threshold_id',
        'name',
        'type',
        'methodology',
        'frequency',
        'measurement_date',
        'percentage',
        'area'
    ];

    public function threshold()
    {
        return $this->belongsTo(ContabilidadThreshold::class, 'threshold_id');
    }

    public function getStatusAttribute()
    {
        if ($this->type === 'informative') {
            return $this->percentage >= 50 ? 'Favorable' : 'Desfavorable';
        }
        $thresholdValue = $this->threshold ? $this->threshold->value : 80;
        return ($this->percentage >= $thresholdValue) ? 'Alcanzado' : 'No Alcanzado';
    }
}