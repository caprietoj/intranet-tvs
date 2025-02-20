<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MaintenanceRequestCreated;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaintenanceRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $requests = MaintenanceRequest::when(!$user->hasAnyRole(['admin', 'mantenimiento']), function($query) use ($user) {
            return $query->where('user_id', $user->id);
        })->with('user')->latest()->paginate(10);
        
        return view('maintenance.index', compact('requests'));
    }

    public function create()
    {
        return view('maintenance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required',
            'description' => 'required',
            'priority' => 'required|in:low,medium,high'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $maintenanceRequest = MaintenanceRequest::create($validated);
        
        // Enviar correo al usuario
        Mail::to(auth()->user()->email)->send(
            new MaintenanceRequestCreated($maintenanceRequest)
        );

        // Enviar correo a mantenimiento
        Mail::to('mantenimiento@tvs.edu.co')->send(
            new MaintenanceRequestCreated($maintenanceRequest)
        );
        
        return redirect()->route('maintenance.index')
            ->with('success', 'Solicitud creada exitosamente');
    }

    public function updateStatus(MaintenanceRequest $maintenance, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected'
        ]);

        $maintenance->update($validated);

        return redirect()->back()
            ->with('success', 'Estado actualizado exitosamente');
    }

    public function dashboard(Request $request)
    {
        $dateRange = $request->get('date_range', 'month');
        $startDate = $this->getStartDate($dateRange);

        // Totales para las tarjetas
        $totalRequests = MaintenanceRequest::where('created_at', '>=', $startDate)->count();
        $pendingRequests = MaintenanceRequest::where('status', 'pending')
            ->where('created_at', '>=', $startDate)->count();
        $completedRequests = MaintenanceRequest::where('status', 'completed')
            ->where('created_at', '>=', $startDate)->count();
        $averageCompletionTime = MaintenanceRequest::where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->whereNotNull('completion_date')
            ->avg(DB::raw('TIMESTAMPDIFF(HOUR, created_at, completion_date)'));

        // Estadísticas por tipo
        $requestsByType = MaintenanceRequest::select('request_type', DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('request_type')
            ->get();

        // Estadísticas por estado
        $requestsByStatus = MaintenanceRequest::select('status', DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('status')
            ->get();

        // Estadísticas por prioridad
        $requestsByPriority = MaintenanceRequest::select('priority', DB::raw('count(*) as total'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('priority')
            ->get();

        // Solicitudes por mes
        $requestsByMonth = MaintenanceRequest::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('count(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Tiempo promedio de resolución por tipo
        $avgTimeByType = MaintenanceRequest::select(
            'request_type',
            DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, completion_date)) as avg_time')
        )
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->groupBy('request_type')
            ->get();

        // Solicitudes recientes con paginación
        $recentRequests = MaintenanceRequest::with('user')
            ->where('created_at', '>=', $startDate)
            ->latest()
            ->paginate(10);

        return view('maintenance.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'completedRequests',
            'averageCompletionTime',
            'requestsByType',
            'requestsByStatus',
            'requestsByPriority',
            'requestsByMonth',
            'avgTimeByType',
            'recentRequests',
            'dateRange'
        ));
    }

    private function getStartDate($range)
    {
        return match($range) {
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'quarter' => Carbon::now()->subQuarter(),
            'year' => Carbon::now()->subYear(),
            default => Carbon::now()->subMonth(),
        };
    }
}
