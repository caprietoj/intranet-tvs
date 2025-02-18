<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Announcement;
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
        $announcements = Announcement::query()
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereDate('expiry_date', '>=', now())
                      ->orWhereNull('expiry_date');
            })
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('announcements'));
    }

    public function dashboard()
    {
        $totalTickets = Ticket::count();
        $abiertos = Ticket::where('estado', 'Abierto')->count();
        $enProceso = Ticket::where('estado', 'En Proceso')->count();
        $cerrados = Ticket::where('estado', 'Cerrado')->count();

        $baja = Ticket::where('prioridad', 'Baja')->count();
        $media = Ticket::where('prioridad', 'Media')->count();
        $alta = Ticket::where('prioridad', 'Alta')->count();

        // Obtener los últimos 10 tickets
        $recentTickets = Ticket::latest()->take(10)->get();

        return view('dashboard', compact(
            'totalTickets', 
            'abiertos', 
            'enProceso', 
            'cerrados',
            'baja',
            'media',
            'alta',
            'recentTickets'
        ));
    }
}
