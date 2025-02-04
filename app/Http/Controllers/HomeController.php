<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Obtener las métricas de tickets
        $totalTickets = Ticket::count();
        $abiertos = Ticket::where('estado', 'Abierto')->count();
        $enProceso = Ticket::where('estado', 'En Proceso')->count();
        $cerrados = Ticket::where('estado', 'Cerrado')->count();

        // Obtener métricas por prioridad
        $baja = Ticket::where('prioridad', 'Baja')->count();
        $media = Ticket::where('prioridad', 'Media')->count();
        $alta = Ticket::where('prioridad', 'Alta')->count();

        return view('home', compact('totalTickets', 'abiertos', 'enProceso', 'cerrados', 'baja', 'media', 'alta'));
    }
}
