<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentLoan extends Model
{
    protected $fillable = [
        'user_id',
        'equipment_id',
        'section',
        'grade',
        'loan_date',
        'start_time',
        'end_time',
        'units_requested',
        'status'
    ];

    protected $casts = [
        'loan_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
