<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 
        'descripcion', 
        'estado', 
        'prioridad', 
        'tipo_requerimiento', 
        'user_id',
        'tecnico_id'
    ];

    // Relación con el usuario que creó el ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el técnico asignado (campo tecnico_id)
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    // Métodos auxiliares
    public static function countByEstado($estado)
    {
        return self::where('estado', $estado)->count();
    }

    public static function countByPrioridad($prioridad)
    {
        return self::where('prioridad', $prioridad)->count();
    }
}