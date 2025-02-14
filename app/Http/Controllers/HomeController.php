<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('welcome');
    }

    public function dashboard(Request $request)
    {
        $period = $request->get('period', 'all');
        
        // Crear una nueva consulta base
        $query = Ticket::query();

        // Aplicar filtros de período si es necesario
        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month);
                break;
        }

        // Clonar la consulta base para cada métrica para evitar interferencias
        $totalTickets = (clone $query)->count();
        $abiertos = (clone $query)->where('estado', 'Abierto')->count();
        $enProceso = (clone $query)->where('estado', 'En Proceso')->count();
        $cerrados = (clone $query)->where('estado', 'Cerrado')->count();

        // Consultas específicas para prioridades
        $alta = (clone $query)->where('prioridad', 'Alta')->count();
        $media = (clone $query)->where('prioridad', 'Media')->count();
        $baja = (clone $query)->where('prioridad', 'Baja')->count();

        // Obtener los últimos tickets con sus relaciones
        $recentTickets = Ticket::with(['user', 'tecnico'])
                              ->latest()
                              ->take(10)
                              ->get();

        // Agregar datos de debug para verificar valores
        $debug = [
            'total' => $totalTickets,
            'prioridades' => [
                'alta' => $alta,
                'media' => $media,
                'baja' => $baja
            ]
        ];

        return view('dashboard', compact(
            'totalTickets', 
            'abiertos', 
            'enProceso', 
            'cerrados',
            'alta',
            'media',
            'baja',
            'recentTickets',
            'debug'  // Agregar datos de debug a la vista
        ));
    }
}
