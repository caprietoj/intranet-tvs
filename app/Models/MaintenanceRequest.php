<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'location',
        'description',
        'priority',
        'status',
        'completion_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
