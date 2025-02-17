<?php

namespace App\Http\Controllers;

use App\Models\ComprasKpi;
use App\Models\ComprasThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KpiComprasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexCompras(Request $request)
    {
        $month = $request->input('month');
        $query = ComprasKpi::with('threshold')->where('area', 'compras');
        
        if ($month) {
            $query->whereMonth('measurement_date', $month);
        }
        
        $kpis = $query->orderBy('measurement_date', 'desc')->get();

        // Separar KPIs por tipo
        $measurementKpis = $kpis->where('type', 'measurement');
        $informativeKpis = $kpis->where('type', 'informative');

        // Estadísticas generales
        $percentages = $kpis->pluck('percentage')->toArray();
        $count = count($percentages);
        
        // Cálculo de la media
        $average = $count > 0 ? array_sum($percentages)/$count : 0;

        // Cálculo de la mediana
        if ($count > 0) {
            sort($percentages);
            $middle = floor($count/2);
            $median = ($count % 2 == 0) ? 
                ($percentages[$middle - 1] + $percentages[$middle]) / 2 : 
                $percentages[$middle];
        } else {
            $median = 0;
        }

        // Cálculo de la desviación estándar
        if ($count > 0) {
            $variance = 0;
            foreach ($percentages as $p) {
                $variance += pow($p - $average, 2);
            }
            $variance /= $count;
            $stdDev = sqrt($variance);
        } else {
            $stdDev = 0;
        }

        // Valores máximo y mínimo
        $max = $count > 0 ? max($percentages) : 0;
        $min = $count > 0 ? min($percentages) : 0;

        // Obtener umbral configurado
        $thresholdRecord = ComprasThreshold::where('area', 'compras')->first();
        $thresholdValue = $thresholdRecord ? $thresholdRecord->value : 80;

        // Contar KPIs bajo el umbral
        $countUnder = $kpis->filter(function($kpi) use ($thresholdValue) {
            return $kpi->percentage < $thresholdValue;
        })->count();

        // Generar conclusión del análisis
        if ($count == 0) {
            $conclusion = "No hay KPIs registrados para el análisis.";
        } else {
            $conclusion = $this->generateConclusion($count, $countUnder, $thresholdValue, $average, $stdDev);
        }

        // Preparar datos para el gráfico
        $chartData = [
            'measurement' => [
                'labels' => $measurementKpis->pluck('name'),
                'data' => $measurementKpis->pluck('percentage'),
            ],
            'informative' => [
                'labels' => $informativeKpis->pluck('name'),
                'data' => $informativeKpis->pluck('percentage'),
            ]
        ];

        return view('kpis.compras.index', compact(
            'kpis',
            'measurementKpis',
            'informativeKpis',
            'average',
            'median',
            'stdDev',
            'max',
            'min',
            'countUnder',
            'conclusion',
            'chartData'
        ));
    }

    public function createCompras()
    {
        $thresholds = ComprasThreshold::where('area', 'compras')->get();
        $types = ['measurement' => 'Medición', 'informative' => 'Informativo'];
        return view('kpis.compras.create', compact('thresholds', 'types'));
    }

    public function storeCompras(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id' => 'required|exists:thresholds,id',
            'type' => 'required|in:measurement,informative',
            'methodology' => 'required|string',
            'frequency' => 'required|in:Diario,Quincenal,Mensual,Semestral',
            'measurement_date' => 'required|date',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $threshold = ComprasThreshold::findOrFail($request->threshold_id);
        
        ComprasKpi::create([
            'threshold_id' => $threshold->id,
            'name' => $threshold->kpi_name,
            'type' => $request->type,
            'area' => 'compras',
            'methodology' => $request->methodology,
            'frequency' => $request->frequency,
            'measurement_date' => $request->measurement_date,
            'percentage' => $request->percentage,
        ]);

        return redirect()
            ->route('kpis.compras.index')
            ->with('success', 'KPI registrado exitosamente.');
    }

    public function showCompras($id)
    {
        $kpi = ComprasKpi::with('threshold')->findOrFail($id);
        return view('kpis.compras.show', compact('kpi'));
    }

    public function editCompras($id)
    {
        $kpi = ComprasKpi::findOrFail($id);
        $thresholds = ComprasThreshold::where('area', 'compras')->get();
        $types = ['measurement' => 'Medición', 'informative' => 'Informativo'];
        return view('kpis.compras.edit', compact('kpi', 'thresholds', 'types'));
    }

    public function updateCompras(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id' => 'required|exists:thresholds,id',
            'type' => 'required|in:measurement,informative',
            'methodology' => 'required|string',
            'frequency' => 'required|in:Diario,Quincenal,Mensual,Semestral',
            'measurement_date' => 'required|date',
            'percentage' => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kpi = ComprasKpi::findOrFail($id);
        $threshold = ComprasThreshold::findOrFail($request->threshold_id);

        $kpi->update([
            'threshold_id' => $threshold->id,
            'name' => $threshold->kpi_name,
            'type' => $request->type,
            'methodology' => $request->methodology,
            'frequency' => $request->frequency,
            'measurement_date' => $request->measurement_date,
            'percentage' => $request->percentage,
        ]);

        return redirect()
            ->route('kpis.compras.show', $kpi->id)
            ->with('success', 'KPI actualizado exitosamente.');
    }

    public function destroyCompras($id)
    {
        $kpi = ComprasKpi::findOrFail($id);
        $kpi->delete();
        
        return response()->json([
            'message' => 'KPI eliminado exitosamente.'
        ], 200);
    }

    private function generateConclusion($count, $countUnder, $thresholdValue, $average, $stdDev)
    {
        $conclusion = "Análisis de {$count} KPIs: ";
        
        if ($countUnder == 0) {
            $conclusion .= "Todos los KPIs superan el umbral establecido ({$thresholdValue}%). ";
        } else {
            $conclusion .= "{$countUnder} KPI(s) están por debajo del umbral ({$thresholdValue}%). ";
        }

        $conclusion .= "La media general es de " . number_format($average, 2) . "% ";
        
        if ($stdDev > 10) {
            $conclusion .= "con una alta variabilidad (desviación estándar: " . number_format($stdDev, 2) . ").";
        } else {
            $conclusion .= "con una variabilidad moderada (desviación estándar: " . number_format($stdDev, 2) . ").";
        }

        return $conclusion;
    }
}