<?php

namespace App\Http\Controllers;

use App\Models\Ausentismo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AusentismoController extends Controller
{
    public function showUploadForm()
    {
        return view('ausentismos.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mes' => 'required',
            'datos' => 'required'
        ]);

        $rows = explode("\n", $request->datos);
        
        foreach($rows as $row) {
            $columns = explode("\t", $row);
            if(count($columns) == 9) {
                try {
                    // Formatear fechas
                    $fechaCreacion = Carbon::createFromFormat('d/m/y H:i', trim($columns[2]))->format('Y-m-d');
                    $fechaDesde = Carbon::createFromFormat('n/j/y H:i', trim($columns[4]))->format('Y-m-d');
                    $fechaHasta = Carbon::createFromFormat('n/j/y H:i', trim($columns[5]))->format('Y-m-d');

                    Ausentismo::create([
                        'persona' => trim($columns[1]),
                        'fecha_de_creacion' => $fechaCreacion,
                        'dependencia' => trim($columns[3]),
                        'fecha_ausencia_desde' => $fechaDesde,
                        'fecha_hasta' => $fechaHasta,
                        'asistencia' => trim($columns[6]),
                        'duracion_ausencia' => trim($columns[7]),
                        'motivo_de_ausencia' => trim($columns[8]),
                        'mes' => $request->mes
                    ]);
                } catch (\Exception $e) {
                    // Log el error y continuar con la siguiente fila
                    \Log::error("Error procesando fila: " . $row);
                    \Log::error($e->getMessage());
                    continue;
                }
            }
        }

        return redirect()->back()->with('success', 'Datos cargados correctamente');
    }

    public function dashboard(Request $request)
    {
        $query = Ausentismo::query();
        
        if ($request->mes) {
            $query->where('mes', $request->mes);
        }

        $totalAusencias = $query->count();
        
        $motivoComun = DB::table('ausentismos')
            ->when($request->mes, function($query) use ($request) {
                return $query->where('mes', $request->mes);
            })
            ->select('motivo_de_ausencia', DB::raw('count(*) as total'))
            ->groupBy('motivo_de_ausencia')
            ->orderByDesc('total')
            ->first();

        $dependenciaAfectada = DB::table('ausentismos')
            ->when($request->mes, function($query) use ($request) {
                return $query->where('mes', $request->mes);
            })
            ->select('dependencia', DB::raw('count(*) as total'))
            ->groupBy('dependencia')
            ->orderByDesc('total')
            ->first();

        $motivosPorcentaje = DB::table('ausentismos')
            ->when($request->mes, function($query) use ($request) {
                return $query->where('mes', $request->mes);
            })
            ->select('motivo_de_ausencia', DB::raw('count(*) as total'))
            ->groupBy('motivo_de_ausencia')
            ->orderBy('total', 'desc')
            ->get();

        $dependenciasPorcentaje = DB::table('ausentismos')
            ->when($request->mes, function($query) use ($request) {
                return $query->where('mes', $request->mes);
            })
            ->select('dependencia', DB::raw('count(*) as total'))
            ->groupBy('dependencia')
            ->orderBy('total', 'desc')
            ->get();

        if ($request->ajax()) {
            return response()->json(compact(
                'totalAusencias',
                'motivoComun',
                'dependenciaAfectada',
                'motivosPorcentaje',
                'dependenciasPorcentaje'
            ));
        }

        return view('ausentismos.dashboard', compact(
            'totalAusencias',
            'motivoComun',
            'dependenciaAfectada',
            'motivosPorcentaje',
            'dependenciasPorcentaje'
        ));
    }

    public function getData(Request $request)
    {
        $query = Ausentismo::select([
            'persona',
            'dependencia',
            'fecha_ausencia_desde',
            'fecha_hasta',
            'motivo_de_ausencia',
            'duracion_ausencia',
            'mes'
        ]);

        if ($request->mes) {
            $query->where('mes', $request->mes);
        }

        if ($request->dependencia) {
            $query->where('dependencia', $request->dependencia);
        }

        if ($request->duracion) {
            if ($request->duracion === 'corta') {
                $query->where(function($q) {
                    $q->where(function($q2) {
                        $q2->where('duracion_ausencia', 'LIKE', '%DIA%')
                           ->where(function($q3) {
                               $q3->where('duracion_ausencia', 'LIKE', '%1%')
                                  ->orWhere('duracion_ausencia', 'LIKE', '%2%')
                                  ->orWhere('duracion_ausencia', 'LIKE', '%3%');
                           });
                    });
                });
            } else if ($request->duracion === 'larga') {
                $query->where(function($q) {
                    $q->where('duracion_ausencia', 'LIKE', '%DIA%')
                      ->where(function($q2) {
                          $q2->whereRaw('CAST(SUBSTRING_INDEX(duracion_ausencia, " ", 1) AS UNSIGNED) > 3');
                      });
                });
            }
        }

        return datatables()
            ->of($query)
            ->addIndexColumn()
            ->make(true);
    }
}
