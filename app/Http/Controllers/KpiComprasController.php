<?php

namespace App\Http\Controllers;

use App\Models\ComprasKpi;
use App\Models\ComprasThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KpiComprasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Listado de KPIs para Compras con análisis estadístico y gráfica
    public function indexCompras(Request $request)
    {
        $month = $request->input('month');
        $query = ComprasKpi::where('area', 'compras');
        if ($month) {
            $query->whereMonth('measurement_date', $month);
        }
        $kpis = $query->orderBy('measurement_date', 'desc')->get();

        // Estadísticas
        $percentages = $kpis->pluck('percentage')->toArray();
        $count = count($percentages);
        $average = $count > 0 ? array_sum($percentages)/$count : 0;

        if ($count > 0) {
            sort($percentages);
            $middle = floor($count/2);
            $median = ($count % 2 == 0) ? ($percentages[$middle - 1] + $percentages[$middle]) / 2 : $percentages[$middle];
        } else {
            $median = 0;
        }

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

        $max = $count > 0 ? max($percentages) : 0;
        $min = $count > 0 ? min($percentages) : 0;

        $thresholdRecord = ComprasThreshold::where('area', 'compras')->first();
        $thresholdValue = $thresholdRecord ? $thresholdRecord->value : 80;

        $countUnder = 0;
        foreach ($percentages as $p) {
            if ($p < $thresholdValue) {
                $countUnder++;
            }
        }

        if ($count == 0) {
            $conclusion = "No hay KPIs registrados.";
        } elseif ($countUnder == $count) {
            $conclusion = "Ningún KPI alcanza el umbral ({$thresholdValue}%).";
        } elseif ($countUnder == 0) {
            $conclusion = "Todos los KPIs están por encima del umbral ({$thresholdValue}%).";
        } else {
            $conclusion = "De un total de {$count} KPIs, {$countUnder} están por debajo del umbral ({$thresholdValue}%).";
        }

        return view('kpis.compras.index', compact('kpis','average','median','stdDev','max','min','countUnder','conclusion'));
    }

    // Formulario para crear un nuevo KPI para Compras
    public function createCompras()
    {
        $thresholds = ComprasThreshold::where('area', 'compras')->get();
        return view('kpis.compras.create', compact('thresholds'));
    }

    // Almacena un nuevo KPI para Compras
    public function storeCompras(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id'     => 'required|exists:thresholds,id',
            'methodology'      => 'required|string',
            'frequency'        => 'required|string|in:Diario,Quincenal,Mensual,Semestral',
            'measurement_date' => 'required|date',
            'percentage'       => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $threshold = ComprasThreshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'compras';

        ComprasKpi::create($data);

        return redirect()->route('kpis.compras.index')->with('success', 'KPI de Compras registrado exitosamente.');
    }

    // Muestra los detalles de un KPI para Compras
    public function showCompras($id)
    {
        $kpi = ComprasKpi::with('threshold')->findOrFail($id);
        return view('kpis.compras.show', compact('kpi'));
    }

    // Formulario para editar un KPI para Compras
    public function editCompras($id)
    {
        $kpi = ComprasKpi::findOrFail($id);
        $thresholds = ComprasThreshold::where('area', 'compras')->get();
        return view('kpis.compras.edit', compact('kpi','thresholds'));
    }

    // Actualiza un KPI para Compras
    public function updateCompras(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id'     => 'required|exists:thresholds,id',
            'methodology'      => 'required|string',
            'frequency'        => 'required|string|in:Diario,Quincenal,Mensual,Semestral',
            'measurement_date' => 'required|date',
            'percentage'       => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kpi = ComprasKpi::findOrFail($id);
        $threshold = ComprasThreshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'compras';

        $kpi->update($data);

        return redirect()->route('kpis.compras.show', $kpi->id)->with('success', 'KPI de Compras actualizado exitosamente.');
    }

    // Elimina un KPI para Compras (usado con SweetAlert2 y AJAX)
    public function destroyCompras($id)
    {
        $kpi = ComprasKpi::findOrFail($id);
        $kpi->delete();
        return response()->json(['message' => 'KPI de Compras eliminado exitosamente.'], 200);
    }
}
