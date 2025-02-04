<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprasThreshold extends Model
{
    use HasFactory;

    protected $table = 'thresholds';

    protected $fillable = [
        'area',
        'kpi_name',
        'value',
    ];
}
