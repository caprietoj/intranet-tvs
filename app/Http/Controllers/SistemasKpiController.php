<?php

namespace App\Http\Controllers;

use App\Models\SistemasKpi;
use App\Models\SistemasThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SistemasKpiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Listado de KPIs para Sistemas con análisis estadístico y gráfica
    public function indexSistemas(Request $request)
    {
        $month = $request->input('month');
        $query = SistemasKpi::query();
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

        $thresholdRecord = SistemasThreshold::first();
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

        return view('kpis.sistemas.index', compact('kpis', 'average', 'median', 'stdDev', 'max', 'min', 'countUnder', 'conclusion'));
    }

    // Muestra el formulario para crear un nuevo KPI para Sistemas
    public function createSistemas()
    {
        $thresholds = SistemasThreshold::all();
        return view('kpis.sistemas.create', compact('thresholds'));
    }

    // Almacena un nuevo KPI para Sistemas
    public function storeSistemas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id' => 'required|exists:sistemas_thresholds,id',
            'methodology'  => 'required|string',
            'frequency'    => 'required|string|in:Diario,Quincenal,Mensual',
            'measurement_date' => 'required|date',
            'percentage'   => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $threshold = SistemasThreshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'sistemas';

        SistemasKpi::create($data);

        return redirect()->route('kpis.sistemas.index')->with('success', 'KPI de Sistemas registrado exitosamente.');
    }

    // Muestra los detalles de un KPI para Sistemas
    public function showSistemas($id)
    {
        $kpi = SistemasKpi::with('threshold')->findOrFail($id);
        return view('kpis.sistemas.show', compact('kpi'));
    }

    // Muestra el formulario para editar un KPI para Sistemas
    public function editSistemas($id)
    {
        $kpi = SistemasKpi::findOrFail($id);
        $thresholds = SistemasThreshold::all();
        return view('kpis.sistemas.edit', compact('kpi', 'thresholds'));
    }

    // Actualiza un KPI para Sistemas
    public function updateSistemas(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id' => 'required|exists:sistemas_thresholds,id',
            'methodology'  => 'required|string',
            'frequency'    => 'required|string|in:Diario,Quincenal,Mensual',
            'measurement_date' => 'required|date',
            'percentage'   => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kpi = SistemasKpi::findOrFail($id);
        $threshold = SistemasThreshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'sistemas';

        $kpi->update($data);

        return redirect()->route('kpis.sistemas.show', $kpi->id)->with('success', 'KPI de Sistemas actualizado exitosamente.');
    }

    // Elimina un KPI para Sistemas (vía AJAX con SweetAlert2)
    public function destroySistemas($id)
    {
        $kpi = SistemasKpi::findOrFail($id);
        $kpi->delete();
        return response()->json(['message' => 'KPI de Sistemas eliminado exitosamente.'], 200);
    }
}
