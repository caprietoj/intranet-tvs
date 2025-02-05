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
use PDF; // Asegúrate de haber instalado barryvdh/laravel-dompdf

class KPIReportController extends Controller
{
    public function downloadReport()
    {
        // Fetch KPI records
        $kpis = Kpi::all();
        $comprasKpis = ComprasKpi::all();
        $recursosKpi = RecursosHumanosKpi::all();
        $sistemasKpi = SistemasKpi::all();

        // Fetch thresholds for each category
        $enfermeriaThresholds = Threshold::all();
        $comprasThresholds = ComprasThreshold::all();
        $rrhhThresholds = RecursosHumanosThreshold::all();
        $sistemasThresholds = SistemasThreshold::all();

        // Compute analysis (averages as a simple statistical summary)
        $enfermeriaAnalysis = [
            'avg_percentage' => $kpis->avg('percentage'),
            'avg_threshold'  => $enfermeriaThresholds->avg('value'),
            'difference'     => $kpis->avg('percentage') - $enfermeriaThresholds->avg('value'),
            'status'         => ($kpis->avg('percentage') < $enfermeriaThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $comprasAnalysis = [
            'avg_percentage' => $comprasKpis->avg('percentage'),
            'avg_threshold'  => $comprasThresholds->avg('value'),
            'difference'     => $comprasKpis->avg('percentage') - $comprasThresholds->avg('value'),
            'status'         => ($comprasKpis->avg('percentage') < $comprasThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $rrhhAnalysis = [
            'avg_percentage' => $recursosKpi->avg('percentage'),
            'avg_threshold'  => $rrhhThresholds->avg('value'),
            'difference'     => $recursosKpi->avg('percentage') - $rrhhThresholds->avg('value'),
            'status'         => ($recursosKpi->avg('percentage') < $rrhhThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $sistemasAnalysis = [
            'avg_percentage' => $sistemasKpi->avg('percentage'),
            'avg_threshold'  => $sistemasThresholds->avg('value'),
            'difference'     => $sistemasKpi->avg('percentage') - $sistemasThresholds->avg('value'),
            'status'         => ($sistemasKpi->avg('percentage') < $sistemasThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];

        // Pass all data to the view
        return view('reports.kpi_report', compact(
            'kpis', 'comprasKpis', 'recursosKpi', 'sistemasKpi',
            'enfermeriaThresholds', 'comprasThresholds', 'rrhhThresholds', 'sistemasThresholds',
            'enfermeriaAnalysis', 'comprasAnalysis', 'rrhhAnalysis', 'sistemasAnalysis'
        ));
    }

    /**
     * Descarga el reporte en formato PDF.
     */
    public function downloadPDF()
    {
        // Reutilizar los mismos datos que en downloadReport()
        $kpis = Kpi::all();
        $comprasKpis = ComprasKpi::all();
        $recursosKpi = RecursosHumanosKpi::all();
        $sistemasKpi = SistemasKpi::all();

        $enfermeriaThresholds = Threshold::all();
        $comprasThresholds = ComprasThreshold::all();
        $rrhhThresholds = RecursosHumanosThreshold::all();
        $sistemasThresholds = SistemasThreshold::all();

        $enfermeriaAnalysis = [
            'avg_percentage' => $kpis->avg('percentage'),
            'avg_threshold'  => $enfermeriaThresholds->avg('value'),
            'difference'     => $kpis->avg('percentage') - $enfermeriaThresholds->avg('value'),
            'status'         => ($kpis->avg('percentage') < $enfermeriaThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $comprasAnalysis = [
            'avg_percentage' => $comprasKpis->avg('percentage'),
            'avg_threshold'  => $comprasThresholds->avg('value'),
            'difference'     => $comprasKpis->avg('percentage') - $comprasThresholds->avg('value'),
            'status'         => ($comprasKpis->avg('percentage') < $comprasThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $rrhhAnalysis = [
            'avg_percentage' => $recursosKpi->avg('percentage'),
            'avg_threshold'  => $rrhhThresholds->avg('value'),
            'difference'     => $recursosKpi->avg('percentage') - $rrhhThresholds->avg('value'),
            'status'         => ($recursosKpi->avg('percentage') < $rrhhThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $sistemasAnalysis = [
            'avg_percentage' => $sistemasKpi->avg('percentage'),
            'avg_threshold'  => $sistemasThresholds->avg('value'),
            'difference'     => $sistemasKpi->avg('percentage') - $sistemasThresholds->avg('value'),
            'status'         => ($sistemasKpi->avg('percentage') < $sistemasThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];

        $data = compact(
            'kpis', 'comprasKpis', 'recursosKpi', 'sistemasKpi',
            'enfermeriaThresholds', 'comprasThresholds', 'rrhhThresholds', 'sistemasThresholds',
            'enfermeriaAnalysis', 'comprasAnalysis', 'rrhhAnalysis', 'sistemasAnalysis'
        );

        // Generar el PDF a partir de la vista
        $pdf = PDF::loadView('reports.kpi_report', $data);
        return $pdf->download('kpi_report.pdf');
    }

    /**
     * Descarga el reporte en formato HTML.
     */
    public function downloadHTML()
    {
        // Reutilizamos la misma lógica para obtener los datos
        $kpis = Kpi::all();
        $comprasKpis = ComprasKpi::all();
        $recursosKpi = RecursosHumanosKpi::all();
        $sistemasKpi = SistemasKpi::all();

        $enfermeriaThresholds = Threshold::all();
        $comprasThresholds = ComprasThreshold::all();
        $rrhhThresholds = RecursosHumanosThreshold::all();
        $sistemasThresholds = SistemasThreshold::all();

        $enfermeriaAnalysis = [
            'avg_percentage' => $kpis->avg('percentage'),
            'avg_threshold'  => $enfermeriaThresholds->avg('value'),
            'difference'     => $kpis->avg('percentage') - $enfermeriaThresholds->avg('value'),
            'status'         => ($kpis->avg('percentage') < $enfermeriaThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $comprasAnalysis = [
            'avg_percentage' => $comprasKpis->avg('percentage'),
            'avg_threshold'  => $comprasThresholds->avg('value'),
            'difference'     => $comprasKpis->avg('percentage') - $comprasThresholds->avg('value'),
            'status'         => ($comprasKpis->avg('percentage') < $comprasThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $rrhhAnalysis = [
            'avg_percentage' => $recursosKpi->avg('percentage'),
            'avg_threshold'  => $rrhhThresholds->avg('value'),
            'difference'     => $recursosKpi->avg('percentage') - $rrhhThresholds->avg('value'),
            'status'         => ($recursosKpi->avg('percentage') < $rrhhThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];
        $sistemasAnalysis = [
            'avg_percentage' => $sistemasKpi->avg('percentage'),
            'avg_threshold'  => $sistemasThresholds->avg('value'),
            'difference'     => $sistemasKpi->avg('percentage') - $sistemasThresholds->avg('value'),
            'status'         => ($sistemasKpi->avg('percentage') < $sistemasThresholds->avg('value'))
                                ? 'No se alcanzó el umbral esperado'
                                : 'Umbral alcanzado'
        ];

        $data = compact(
            'kpis', 'comprasKpis', 'recursosKpi', 'sistemasKpi',
            'enfermeriaThresholds', 'comprasThresholds', 'rrhhThresholds', 'sistemasThresholds',
            'enfermeriaAnalysis', 'comprasAnalysis', 'rrhhAnalysis', 'sistemasAnalysis'
        );

        $html = view('reports.kpi_report', $data)->render();
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="kpi_report.html"');
    }
}