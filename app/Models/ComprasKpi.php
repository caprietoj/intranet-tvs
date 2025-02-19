<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasKpi extends Model
{
    use HasFactory;

    protected $table = 'compras_kpis';

    protected $fillable = [
        'threshold_id',
        'name',
        'type',
        'methodology',
        'frequency',
        'measurement_date',
        'percentage',
        'status'
    ];

    protected $casts = [
        'measurement_date' => 'date',
        'percentage' => 'decimal:2'
    ];

    // Relación con el threshold
    public function threshold()
    {
        return $this->belongsTo(ComprasThreshold::class, 'threshold_id');
    }

    // Calcular status automáticamente
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($kpi) {
            $threshold = $kpi->threshold;
            if ($threshold) {
                $kpi->status = $kpi->percentage >= $threshold->value ? 'Alcanzado' : 'No Alcanzado';
            }
        });
    }
}