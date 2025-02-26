<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'request_type',
        'location',
        'description',
        'priority',
        'status',
        'technician_id',
        'completion_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
