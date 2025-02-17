<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContabilidadThreshold extends Model
{
    protected $fillable = [
        'kpi_name',
        'value',
        'description'
    ];

    public function kpis()
    {
        return $this->hasMany(ContabilidadKpi::class, 'threshold_id');
    }
}