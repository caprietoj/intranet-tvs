<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;
use App\Models\ComprasKpi;
use App\Models\RecursosHumanosKpi;
use App\Models\SistemasKpi;
use App\Models\Threshold;
use App\Models\ComprasThreshold;
use App\Models\RecursosHumanosThreshold;
use App\Models\SistemasThreshold;

class KPIReportController extends Controller
{
    public function index()
    {
        try {
            // Fetch KPI records with error handling
            $kpis = Kpi::all() ?? collect([]);
            $comprasKpis = ComprasKpi::all() ?? collect([]);
            $recursosKpi = RecursosHumanosKpi::all() ?? collect([]);
            $sistemasKpi = SistemasKpi::all() ?? collect([]);

            // Fetch thresholds with error handling
            $enfermeriaThresholds = Threshold::all() ?? collect([]);
            $comprasThresholds = ComprasThreshold::all() ?? collect([]);
            $rrhhThresholds = RecursosHumanosThreshold::all() ?? collect([]);
            $sistemasThresholds = SistemasThreshold::all() ?? collect([]);

            // Compute analysis with safe calculations
            $enfermeriaAnalysis = [
                'avg_percentage' => $kpis->avg('percentage') ?? 0,
                'avg_threshold' => $enfermeriaThresholds->avg('value') ?? 0,
                'difference' => ($kpis->avg('percentage') ?? 0) - ($enfermeriaThresholds->avg('value') ?? 0),
                'status' => ($kpis->avg('percentage') ?? 0) < ($enfermeriaThresholds->avg('value') ?? 0)
                    ? 'No se alcanzó el umbral esperado'
                    : 'Umbral alcanzado'
            ];

            $comprasAnalysis = [
                'avg_percentage' => $comprasKpis->avg('percentage') ?? 0,
                'avg_threshold' => $comprasThresholds->avg('value') ?? 0,
                'difference' => ($comprasKpis->avg('percentage') ?? 0) - ($comprasThresholds->avg('value') ?? 0),
                'status' => ($comprasKpis->avg('percentage') ?? 0) < ($comprasThresholds->avg('value') ?? 0)
                    ? 'No se alcanzó el umbral esperado'
                    : 'Umbral alcanzado'
            ];

            $rrhhAnalysis = [
                'avg_percentage' => $recursosKpi->avg('percentage') ?? 0,
                'avg_threshold' => $rrhhThresholds->avg('value') ?? 0,
                'difference' => ($recursosKpi->avg('percentage') ?? 0) - ($rrhhThresholds->avg('value') ?? 0),
                'status' => ($recursosKpi->avg('percentage') ?? 0) < ($rrhhThresholds->avg('value') ?? 0)
                    ? 'No se alcanzó el umbral esperado'
                    : 'Umbral alcanzado'
            ];

            $sistemasAnalysis = [
                'avg_percentage' => $sistemasKpi->avg('percentage') ?? 0,
                'avg_threshold' => $sistemasThresholds->avg('value') ?? 0,
                'difference' => ($sistemasKpi->avg('percentage') ?? 0) - ($sistemasThresholds->avg('value') ?? 0),
                'status' => ($sistemasKpi->avg('percentage') ?? 0) < ($sistemasThresholds->avg('value') ?? 0)
                    ? 'No se alcanzó el umbral esperado'
                    : 'Umbral alcanzado'
            ];

            return view('reports.kpi_report', compact(
                'kpis', 'comprasKpis', 'recursosKpi', 'sistemasKpi',
                'enfermeriaThresholds', 'comprasThresholds', 'rrhhThresholds', 'sistemasThresholds',
                'enfermeriaAnalysis', 'comprasAnalysis', 'rrhhAnalysis', 'sistemasAnalysis'
            ));

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error en KPIReportController: ' . $e->getMessage());
            
            // Return a view with error message
            return view('reports.kpi_report', [
                'error' => 'Hubo un error al procesar los datos. Por favor, inténtelo de nuevo.'
            ]);
        }
    }
}