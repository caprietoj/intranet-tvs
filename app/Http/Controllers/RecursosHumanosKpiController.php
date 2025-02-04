<?php

namespace App\Http\Controllers;

use App\Models\RecursosHumanosKpi;
use App\Models\RecursosHumanosThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecursosHumanosKpiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Listado de KPIs para RRHH con análisis estadístico y gráfica
    public function indexRecursosHumanos(Request $request)
    {
        $month = $request->input('month');
        $query = RecursosHumanosKpi::query();
        if ($month) {
            $query->whereMonth('measurement_date', $month);
        }
        $kpis = $query->orderBy('measurement_date', 'desc')->get();

        $percentages = $kpis->pluck('percentage')->toArray();
        $count = count($percentages);
        $average = $count > 0 ? array_sum($percentages) / $count : 0;

        if ($count > 0) {
            sort($percentages);
            $middle = floor($count / 2);
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

        // Se obtiene el umbral configurado para RRHH; si no existe, se usa 80%
        $thresholdRecord = RecursosHumanosThreshold::first();
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

        return view('kpis.rrhh.index', compact('kpis','average','median','stdDev','max','min','countUnder','conclusion'));
    }

    // Muestra el formulario para crear un nuevo KPI para RRHH
    public function createRecursosHumanos()
    {
        $thresholds = RecursosHumanosThreshold::all();
        return view('kpis.rrhh.create', compact('thresholds'));
    }

    // Almacena un nuevo KPI para RRHH
    public function storeRecursosHumanos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id' => 'required|exists:recursos_humanos_thresholds,id',
            'methodology'  => 'required|string',
            'frequency'    => 'required|string|in:Diario,Quincenal,Mensual',
            'measurement_date' => 'required|date',
            'percentage'   => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $threshold = RecursosHumanosThreshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'rrhh';
        RecursosHumanosKpi::create($data);

        return redirect()->route('kpis.rrhh.index')->with('success', 'KPI de Recursos Humanos registrado exitosamente.');
    }

    // Muestra los detalles de un KPI para RRHH
    public function showRecursosHumanos($id)
    {
        $kpi = RecursosHumanosKpi::with('threshold')->findOrFail($id);
        return view('kpis.rrhh.show', compact('kpi'));
    }

    // Muestra el formulario para editar un KPI para RRHH
    public function editRecursosHumanos($id)
    {
        $kpi = RecursosHumanosKpi::findOrFail($id);
        $thresholds = RecursosHumanosThreshold::all();
        return view('kpis.rrhh.edit', compact('kpi','thresholds'));
    }

    // Actualiza un KPI para RRHH
    public function updateRecursosHumanos(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id' => 'required|exists:recursos_humanos_thresholds,id',
            'methodology'  => 'required|string',
            'frequency'    => 'required|string|in:Diario,Quincenal,Mensual',
            'measurement_date' => 'required|date',
            'percentage'   => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kpi = RecursosHumanosKpi::findOrFail($id);
        $threshold = RecursosHumanosThreshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'rrhh';
        $kpi->update($data);

        return redirect()->route('kpis.rrhh.show', $kpi->id)->with('success', 'KPI de Recursos Humanos actualizado exitosamente.');
    }

    // Elimina un KPI para RRHH (con SweetAlert2 vía AJAX)
    public function destroyRecursosHumanos($id)
    {
        $kpi = RecursosHumanosKpi::findOrFail($id);
        $kpi->delete();
        return response()->json(['message' => 'KPI de Recursos Humanos eliminado exitosamente.'], 200);
    }
}
