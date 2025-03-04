<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreated;
use App\Models\Configuration;  // Agregar esta línea

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 
        'descripcion', 
        'estado', 
        'prioridad',  // Asegúrate de que este campo esté incluido
        'tipo_requerimiento', 
        'user_id',
        'tecnico_id'
    ];

    // Agregar constantes para los valores de prioridad
    public const PRIORIDAD_ALTA = 'Alta';
    public const PRIORIDAD_MEDIA = 'Media';
    public const PRIORIDAD_BAJA = 'Baja';

    protected static function booted()
    {
        static::created(function($ticket) {
            // Obtener correos configurados
            $config = Configuration::where('key', 'helpdesk_emails')->first();
            $supportEmails = $config ? explode(',', $config->value) : [];
            
            // Enviar a todos los correos configurados
            foreach ($supportEmails as $email) {
                Mail::to(trim($email))->send(new TicketCreated($ticket));
            }

            // Enviar al usuario que creó el ticket
            if ($ticket->user && $ticket->user->email) {
                Mail::to($ticket->user->email)->send(new TicketCreated($ticket));
            }
        });
    }

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

    public function getStatusColor()
    {
        return match($this->estado) {
            'Abierto' => 'warning',
            'En Proceso' => 'info',
            'Cerrado' => 'success',
            default => 'secondary'
        };
    }

    public function getPriorityColor()
    {
        return match($this->prioridad) {
            'Alta' => 'danger',
            'Media' => 'warning',
            'Baja' => 'success',
            default => 'secondary'
        };
    }
}