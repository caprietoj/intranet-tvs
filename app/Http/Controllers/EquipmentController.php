<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentLoan;
use App\Mail\EquipmentLoanRequested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:equipment.manage')->only(['resetInventory']);
    }

    public function index()
    {
        $equipment = Equipment::all();
        return view('equipment.index', compact('equipment'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:laptop,ipad',
            'section' => 'required|in:bachillerato,preescolar_primaria',
            'total_units' => 'required|integer|min:1'
        ]);

        $equipment = Equipment::create([
            'type' => $validated['type'],
            'section' => $validated['section'],
            'total_units' => $validated['total_units'],
            'available_units' => $validated['total_units']
        ]);

        return redirect()->route('equipment.index')
            ->with('success', 'Equipos registrados correctamente');
    }

    public function requestLoan(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'section' => 'required',
            'grade' => 'required',
            'loan_date' => 'required|date|after:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'units_requested' => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $equipment = Equipment::findOrFail($validated['equipment_id']);

            if ($equipment->available_units < $validated['units_requested']) {
                return back()->with('error', 'No hay suficientes equipos disponibles');
            }

            $loan = EquipmentLoan::create([
                'user_id' => auth()->id(),
                'equipment_id' => $equipment->id,
                'section' => $validated['section'],
                'grade' => $validated['grade'],
                'loan_date' => $validated['loan_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'units_requested' => $validated['units_requested']
            ]);

            $equipment->decrement('available_units', $validated['units_requested']);

            try {
                Mail::to('caprietoj@gmail.com')->send(new EquipmentLoanRequested($loan));
            } catch (\Exception $e) {
                // Log el error pero no interrumpir la transacción
                \Log::error("Error enviando correo: " . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('equipment.loans')
                ->with('success', 'Solicitud de préstamo registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    public function resetInventory()
    {
        try {
            Log::info('Iniciando reseteo de inventario');
            
            DB::beginTransaction();
            
            $affected = Equipment::query()->update([
                'available_units' => DB::raw('total_units')
            ]);
            
            Log::info('Equipos actualizados: ' . $affected);
            
            DB::commit();
            
            if ($affected > 0) {
                return redirect()->back()->with('success', 'Inventario reiniciado correctamente (' . $affected . ' equipos actualizados)');
            }
            
            return redirect()->back()->with('info', 'No hubo cambios en el inventario');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en resetInventory: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al reiniciar el inventario. Por favor, intente nuevamente.');
        }
    }

    public function showRequestForm()
    {
        $equipment = Equipment::all();
        return view('equipment.request', compact('equipment'));
    }

    public function showLoans()
    {
        $loans = EquipmentLoan::with(['equipment', 'user'])
            ->orderBy('loan_date', 'desc')
            ->get();
        return view('equipment.loans', compact('loans'));
    }

    public function inventory()
    {
        $equipment = Equipment::all();
        return view('equipment.inventory', compact('equipment'));
    }

    public function dashboard()
    {
        // Obtener estadísticas generales
        $totalLoans = EquipmentLoan::count();
        $activeLoans = EquipmentLoan::where('loan_date', '>=', now())->count();
        
        // Préstamos por sección
        $loansBySection = EquipmentLoan::select('section', DB::raw('count(*) as total'))
            ->groupBy('section')
            ->get();

        // Equipos más solicitados - Corregida la ambigüedad de la columna section
        $mostRequestedEquipment = Equipment::select(
            'equipment.type',
            'equipment.section',
            DB::raw('count(*) as total_loans')
        )
            ->join('equipment_loans', 'equipment.id', '=', 'equipment_loans.equipment_id')
            ->groupBy('equipment.type', 'equipment.section')
            ->orderBy('total_loans', 'desc')
            ->get();

        // Préstamos por mes
        $loansByMonth = EquipmentLoan::select(
            DB::raw('MONTH(loan_date) as month'),
            DB::raw('count(*) as total')
        )
            ->whereYear('loan_date', now()->year)
            ->groupBy('month')
            ->get();

        return view('equipment.dashboard', compact(
            'totalLoans',
            'activeLoans',
            'loansBySection',
            'mostRequestedEquipment',
            'loansByMonth'
        ));
    }

    public function getLoansData(Request $request)
    {
        try {
            $loans = EquipmentLoan::join('equipment', 'equipment_loans.equipment_id', '=', 'equipment.id')
                ->select(
                    'equipment_loans.*',
                    'equipment.type as equipment_type'
                );

            if ($request->filled('month')) {
                $loans->whereMonth('loan_date', $request->month);
            }

            $loansData = $loans->get();

            // Calcular los totales para el resumen
            $summary = [
                'ipads_primaria' => $loansData->where('section', 'preescolar_primaria')
                    ->where('equipment_type', 'ipad')
                    ->count(),
                'ipads_bachillerato' => $loansData->where('section', 'bachillerato')
                    ->where('equipment_type', 'ipad')
                    ->count(),
                'laptops_bachillerato' => $loansData->where('section', 'bachillerato')
                    ->where('equipment_type', 'laptop')
                    ->count()
            ];

            return response()->json([
                'draw' => request()->draw,
                'recordsTotal' => $loansData->count(),
                'recordsFiltered' => $loansData->count(),
                'data' => $loansData->map(function($loan) {
                    return [
                        'section' => $loan->section,
                        'grade' => $loan->grade,
                        'equipment_type' => $loan->equipment_type,
                        'units_requested' => $loan->units_requested,
                        'loan_date' => $loan->loan_date ? Carbon::parse($loan->loan_date)->format('d/m/Y') : '',
                        'start_time' => $loan->start_time ? Carbon::parse($loan->start_time)->format('H:i') : '',
                        'end_time' => $loan->end_time ? Carbon::parse($loan->end_time)->format('H:i') : ''
                    ];
                }),
                'summary' => $summary
            ]);
        } catch (\Exception $e) {
            Log::error('Error en getLoansData: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error al obtener los datos: ' . $e->getMessage()
            ], 500);
        }
    }
}
