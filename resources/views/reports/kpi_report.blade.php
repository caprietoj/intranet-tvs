@extends('adminlte::page')

@section('title', 'Informe Profesional de KPIs')

@section('content_header')
    <h1>Informe KPIs</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <!-- Enfermería -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h2>KPIs Enfermería</h2>
                    <div class="analysis">
                        <p>
                            Promedio Real: {{ number_format($enfermeriaAnalysis['avg_percentage'], 2) }} | 
                            Promedio Esperado: {{ number_format($enfermeriaAnalysis['avg_threshold'], 2) }}
                        </p>
                        <p>
                            Diferencia: {{ number_format($enfermeriaAnalysis['difference'], 2) }} - {{ $enfermeriaAnalysis['status'] }}
                        </p>
                    </div>
                    @if($enfermeriaThresholds->count() && $kpis->count())
                        <canvas id="kpiChart"></canvas>
                    @else
                        <p style="text-align:center;">No hay datos disponibles.</p>
                    @endif
                </div>
            </div>

            <!-- Compras -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h2>KPIs de Compras</h2>
                    <div class="analysis">
                        <p>
                            Promedio Real: {{ number_format($comprasAnalysis['avg_percentage'], 2) }} | 
                            Promedio Esperado: {{ number_format($comprasAnalysis['avg_threshold'], 2) }}
                        </p>
                        <p>
                            Diferencia: {{ number_format($comprasAnalysis['difference'], 2) }} - {{ $comprasAnalysis['status'] }}
                        </p>
                    </div>
                    @if($comprasThresholds->count() && $comprasKpis->count())
                        <canvas id="comprasKpiChart"></canvas>
                    @else
                        <p style="text-align:center;">No hay datos disponibles.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recursos Humanos -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h2>KPIs de Recursos Humanos</h2>
                    <div class="analysis">
                        <p>
                            Promedio Real: {{ number_format($rrhhAnalysis['avg_percentage'], 2) }} | 
                            Promedio Esperado: {{ number_format($rrhhAnalysis['avg_threshold'], 2) }}
                        </p>
                        <p>
                            Diferencia: {{ number_format($rrhhAnalysis['difference'], 2) }} - {{ $rrhhAnalysis['status'] }}
                        </p>
                    </div>
                    @if($rrhhThresholds->count() && $recursosKpi->count())
                        <canvas id="recursosKpiChart"></canvas>
                    @else
                        <p style="text-align:center;">No hay datos disponibles.</p>
                    @endif
                </div>
            </div>

            <!-- Sistemas -->
            <div class="col-md-6">
                <div class="chart-container">
                    <h2>KPIs de Sistemas</h2>
                    <div class="analysis">
                        <p>
                            Promedio Real: {{ number_format($sistemasAnalysis['avg_percentage'], 2) }} | 
                            Promedio Esperado: {{ number_format($sistemasAnalysis['avg_threshold'], 2) }}
                        </p>
                        <p>
                            Diferencia: {{ number_format($sistemasAnalysis['difference'], 2) }} - {{ $sistemasAnalysis['status'] }}
                        </p>
                    </div>
                    @if($sistemasThresholds->count() && $sistemasKpi->count())
                        <canvas id="sistemasKpiChart"></canvas>
                    @else
                        <p style="text-align:center;">No hay datos disponibles.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .row {
        margin-bottom: 30px;
    }
    .chart-container {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        padding: 30px;
    }
    canvas {
        width: 100% !important;
        height: auto !important;
    }
    .analysis {
        text-align: center;
        margin-bottom: 10px;
        font-weight: bold;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico para KPIs de Enfermería
    @if($enfermeriaThresholds->count() && $kpis->count())
    const enfermeriaLabels   = {!! json_encode($enfermeriaThresholds->pluck('kpi_name')) !!};
    const enfermeriaActual   = {!! json_encode($kpis->pluck('percentage')) !!};
    const enfermeriaExpected = {!! json_encode($enfermeriaThresholds->pluck('value')) !!};

    const kpiData = {
        labels: enfermeriaLabels,
        datasets: [
            {
                label: 'Real (%)',
                data: enfermeriaActual,
                backgroundColor: 'rgba(60,141,188,0.7)'
            },
            {
                label: 'Umbral (%)',
                data: enfermeriaExpected,
                backgroundColor: 'rgba(220,53,69,0.7)'
            }
        ]
    };

    const configKpi = {
        type: 'bar',
        data: kpiData,
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    };

    new Chart(document.getElementById('kpiChart').getContext('2d'), configKpi);
    @endif

    // Gráfico para KPIs de Compras
    @if($comprasThresholds->count() && $comprasKpis->count())
    const comprasLabels   = {!! json_encode($comprasThresholds->pluck('kpi_name')) !!};
    const comprasActual   = {!! json_encode($comprasKpis->pluck('percentage')) !!};
    const comprasExpected = {!! json_encode($comprasThresholds->pluck('value')) !!};

    const comprasData = {
        labels: comprasLabels,
        datasets: [
            {
                label: 'Real (%)',
                data: comprasActual,
                backgroundColor: 'rgba(0,166,90,0.7)'
            },
            {
                label: 'Umbral (%)',
                data: comprasExpected,
                backgroundColor: 'rgba(255,193,7,0.7)'
            }
        ]
    };

    const configCompras = {
        type: 'bar',
        data: comprasData,
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    };

    new Chart(document.getElementById('comprasKpiChart').getContext('2d'), configCompras);
    @endif

    // Gráfico para KPIs de Recursos Humanos
    @if($rrhhThresholds->count() && $recursosKpi->count())
    const rrhhLabels   = {!! json_encode($rrhhThresholds->pluck('kpi_name')) !!};
    const rrhhActual   = {!! json_encode($recursosKpi->pluck('percentage')) !!};
    const rrhhExpected = {!! json_encode($rrhhThresholds->pluck('value')) !!};

    const rrhhData = {
        labels: rrhhLabels,
        datasets: [
            {
                label: 'Real (%)',
                data: rrhhActual,
                backgroundColor: 'rgba(243,156,18,0.7)'
            },
            {
                label: 'Umbral (%)',
                data: rrhhExpected,
                backgroundColor: 'rgba(40,167,69,0.7)'
            }
        ]
    };

    const configRecursos = {
        type: 'bar',
        data: rrhhData,
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    };

    new Chart(document.getElementById('recursosKpiChart').getContext('2d'), configRecursos);
    @endif

    // Gráfico para KPIs de Sistemas
    @if($sistemasThresholds->count() && $sistemasKpi->count())
    const sistemasLabels   = {!! json_encode($sistemasThresholds->pluck('kpi_name')) !!};
    const sistemasActual   = {!! json_encode($sistemasKpi->pluck('percentage')) !!};
    const sistemasExpected = {!! json_encode($sistemasThresholds->pluck('value')) !!};

    const sistemasData = {
        labels: sistemasLabels,
        datasets: [
            {
                label: 'Real (%)',
                data: sistemasActual,
                backgroundColor: 'rgba(210,214,222,0.7)'
            },
            {
                label: 'Umbral (%)',
                data: sistemasExpected,
                backgroundColor: 'rgba(23,162,184,0.7)'
            }
        ]
    };

    const configSistemas = {
        type: 'bar',
        data: sistemasData,
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    };

    new Chart(document.getElementById('sistemasKpiChart').getContext('2d'), configSistemas);
    @endif
});
</script>
@stop