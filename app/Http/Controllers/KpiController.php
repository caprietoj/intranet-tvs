<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use App\Models\Threshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KpiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra el listado de KPIs para el área de Enfermería junto con el análisis estadístico.
     *
     * Variables calculadas:
     * - $kpis: Colección de KPIs para Enfermería.
     * - $average: Media de los porcentajes alcanzados.
     * - $median: Mediana de los porcentajes.
     * - $stdDev: Desviación estándar.
     * - $max: Valor máximo.
     * - $min: Valor mínimo.
     * - $countUnder: Cantidad de KPIs cuyo porcentaje está por debajo del umbral.
     * - $conclusion: Conclusión automática basada en los datos.
     */
    public function indexEnfermeria(Request $request)
    {
        // Filtrado opcional por mes
        $month = $request->input('month');
        $query = Kpi::where('area', 'enfermeria');
        if ($month) {
            $query->whereMonth('measurement_date', $month);
        }
        $kpis = $query->orderBy('measurement_date', 'desc')->get();

        // Extraer los porcentajes de cada KPI
        $percentages = $kpis->pluck('percentage')->toArray();
        $count = count($percentages);

        // Calcular la media
        $average = $count > 0 ? array_sum($percentages) / $count : 0;

        // Calcular la mediana
        if ($count > 0) {
            sort($percentages);
            $middle = floor($count / 2);
            if ($count % 2 == 0) {
                $median = ($percentages[$middle - 1] + $percentages[$middle]) / 2;
            } else {
                $median = $percentages[$middle];
            }
        } else {
            $median = 0;
        }

        // Calcular la desviación estándar
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

        // Obtener valor máximo y mínimo
        $max = $count > 0 ? max($percentages) : 0;
        $min = $count > 0 ? min($percentages) : 0;

        // Obtener el umbral configurado para Enfermería; si no existe, usar 80 por defecto
        $thresholdRecord = Threshold::where('area', 'enfermeria')->first();
        $thresholdValue = $thresholdRecord ? $thresholdRecord->value : 80;

        // Contar cuántos KPIs tienen porcentaje inferior al umbral
        $countUnder = 0;
        foreach ($percentages as $p) {
            if ($p < $thresholdValue) {
                $countUnder++;
            }
        }

        // Generar conclusión basada en los datos:
        if ($count == 0) {
            $conclusion = "No hay KPIs registrados.";
        } elseif ($countUnder == $count) {
            $conclusion = "Ningún KPI alcanza el umbral ({$thresholdValue}%).";
        } elseif ($countUnder == 0) {
            $conclusion = "Todos los KPIs están por encima del umbral ({$thresholdValue}%).";
        } else {
            $conclusion = "De un total de {$count} KPIs, {$countUnder} están por debajo del umbral ({$thresholdValue}%).";
        }

        return view('kpis.enfermeria.index', compact('kpis', 'average', 'median', 'stdDev', 'max', 'min', 'countUnder', 'conclusion'));
    }

    /**
     * Muestra el formulario para crear un nuevo KPI para el área de Enfermería.
     */
    public function createEnfermeria()
    {
        // Se obtienen los thresholds configurados para el área "enfermeria"
        $thresholds = Threshold::where('area', 'enfermeria')->get();
        return view('kpis.enfermeria.create', compact('thresholds'));
    }

    /**
     * Almacena un nuevo KPI para el área de Enfermería.
     */
    public function storeEnfermeria(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id'     => 'required|exists:thresholds,id',
            'methodology'      => 'required|string',
            'frequency'        => 'required|string|in:Diario,Quincenal,Mensual,Semestral',
            'measurement_date' => 'required|date',
            'percentage'       => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener la configuración del KPI (threshold) seleccionado
        $threshold = Threshold::findOrFail($request->threshold_id);
        $data = $request->all();
        // Asignar el nombre del KPI según lo configurado en el threshold
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'enfermeria';

        Kpi::create($data);

        // Redirige al listado de KPIs (Ver KPI)
        return redirect()->route('kpis.enfermeria.index')->with('success', 'KPI de Enfermería registrado exitosamente.');
    }

    /**
     * Muestra los detalles de un KPI para el área de Enfermería.
     */
    public function showEnfermeria($id)
    {
        $kpi = Kpi::with('threshold')->findOrFail($id);
        return view('kpis.enfermeria.show', compact('kpi'));
    }

    /**
     * Muestra el formulario para editar un KPI para el área de Enfermería.
     */
    public function editEnfermeria($id)
    {
        $kpi = Kpi::findOrFail($id);
        $thresholds = Threshold::where('area', 'enfermeria')->get();
        return view('kpis.enfermeria.edit', compact('kpi', 'thresholds'));
    }

    /**
     * Actualiza un KPI para el área de Enfermería.
     */
    public function updateEnfermeria(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'threshold_id'     => 'required|exists:thresholds,id',
            'methodology'      => 'required|string',
            'frequency'        => 'required|string|in:Diario,Quincenal,Mensual,Semestral',
            'measurement_date' => 'required|date',
            'percentage'       => 'required|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kpi = Kpi::findOrFail($id);
        $threshold = Threshold::findOrFail($request->threshold_id);
        $data = $request->all();
        $data['name'] = $threshold->kpi_name;
        $data['threshold_id'] = $threshold->id;
        $data['area'] = 'enfermeria';

        $kpi->update($data);

        return redirect()->route('kpis.enfermeria.show', $kpi->id)->with('success', 'KPI de Enfermería actualizado exitosamente.');
    }

    /**
     * Elimina un KPI para el área de Enfermería.
     * Este método devuelve una respuesta JSON para integrarlo con SweetAlert2.
     */
    public function destroyEnfermeria($id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();
        return response()->json(['message' => 'KPI de Enfermería eliminado exitosamente.'], 200);
    }
}
