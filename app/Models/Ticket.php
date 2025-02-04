<?php

// app/Models/Ticket.php
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
        'user_id'
    ];

    // Relación con el usuario creador
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Métodos auxiliares para contar tickets
    public static function countByEstado($estado)
    {
        return self::where('estado', $estado)->count();
    }

    public static function countByPrioridad($prioridad)
    {
        return self::where('prioridad', $prioridad)->count();
    }
}
