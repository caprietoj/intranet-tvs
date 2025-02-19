@extends('adminlte::page')

@section('title', 'Dashboard KPIs')

@section('content_header')
    <h1 class="text-primary">Dashboard de KPIs Institucionales</h1>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Resumen General -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ number_format($enfermeriaAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs Enfermería</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ number_format($comprasAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs Compras</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($rrhhAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs RRHH</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ number_format($sistemasAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs Sistemas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos Principales -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-heartbeat mr-2"></i>
                            KPIs Enfermería
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="enfermeriaChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            KPIs Compras
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="comprasChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users mr-2"></i>
                            KPIs Recursos Humanos
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="rrhhChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-laptop-code mr-2"></i>
                            KPIs Sistemas
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="sistemasChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reemplazar la sección del Análisis Comparativo -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-2"></i>
                            Análisis Comparativo de KPIs
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <canvas id="comparativeChart" height="300"></canvas>
                            </div>
                            <div class="col-md-4">
                                <div class="analysis-summary">
                                    <h4 class="text-primary mb-4">Resumen de Rendimiento</h4>
                                    <div class="summary-item mb-3">
                                        <h5>Enfermería</h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" 
                                                 style="width: {{ $enfermeriaAnalysis['avg_percentage'] }}%" 
                                                 aria-valuenow="{{ $enfermeriaAnalysis['avg_percentage'] }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($enfermeriaAnalysis['avg_percentage'], 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-item mb-3">
                                        <h5>Compras</h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: {{ $comprasAnalysis['avg_percentage'] }}%" 
                                                 aria-valuenow="{{ $comprasAnalysis['avg_percentage'] }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($comprasAnalysis['avg_percentage'], 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-item mb-3">
                                        <h5>RRHH</h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" 
                                                 style="width: {{ $rrhhAnalysis['avg_percentage'] }}%" 
                                                 aria-valuenow="{{ $rrhhAnalysis['avg_percentage'] }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($rrhhAnalysis['avg_percentage'], 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-item mb-3">
                                        <h5>Sistemas</h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" role="progressbar" 
                                                 style="width: {{ $sistemasAnalysis['avg_percentage'] }}%" 
                                                 aria-valuenow="{{ $sistemasAnalysis['avg_percentage'] }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($sistemasAnalysis['avg_percentage'], 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .small-box {
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    .small-box:hover {
        transform: translateY(-5px);
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #364E76;
        color: white;
        border-radius: 8px 8px 0 0;
    }
    .chart-container {
        position: relative;
        margin: auto;
    }
    .analysis-summary {
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-radius: 8px;
    }

    .summary-item h5 {
        color: #364E76;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .progress {
        height: 25px;
        border-radius: 6px;
        background-color: #e9ecef;
    }

    .progress-bar {
        font-size: 0.9rem;
        font-weight: 600;
        line-height: 25px;
        transition: width 0.6s ease;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        },
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    };

    // Enfermería Chart
    new Chart(document.getElementById('enfermeriaChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($enfermeriaThresholds->pluck('kpi_name')) !!},
            datasets: [{
                label: 'Porcentaje Alcanzado',
                data: {!! json_encode($kpis->pluck('percentage')) !!},
                backgroundColor: 'rgba(60, 141, 188, 0.7)',
                borderColor: 'rgba(60, 141, 188, 1)',
                borderWidth: 1
            }, {
                label: 'Umbral',
                data: {!! json_encode($enfermeriaThresholds->pluck('value')) !!},
                type: 'line',
                borderColor: '#ED3236',
                borderWidth: 2,
                fill: false
            }]
        },
        options: chartOptions
    });

    // Compras Chart
    new Chart(document.getElementById('comprasChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($comprasThresholds->pluck('kpi_name')) !!},
            datasets: [{
                label: 'Porcentaje Alcanzado',
                data: {!! json_encode($comprasKpis->pluck('percentage')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }, {
                label: 'Umbral',
                data: {!! json_encode($comprasThresholds->pluck('value')) !!},
                type: 'line',
                borderColor: '#ED3236',
                borderWidth: 2,
                fill: false
            }]
        },
        options: chartOptions
    });

    // RRHH Chart
    new Chart(document.getElementById('rrhhChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($rrhhThresholds->pluck('kpi_name')) !!},
            datasets: [{
                label: 'Porcentaje Alcanzado',
                data: {!! json_encode($recursosKpi->pluck('percentage')) !!},
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }, {
                label: 'Umbral',
                data: {!! json_encode($rrhhThresholds->pluck('value')) !!},
                type: 'line',
                borderColor: '#ED3236',
                borderWidth: 2,
                fill: false
            }]
        },
        options: chartOptions
    });

    // Sistemas Chart
    new Chart(document.getElementById('sistemasChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($sistemasThresholds->pluck('kpi_name')) !!},
            datasets: [{
                label: 'Porcentaje Alcanzado',
                data: {!! json_encode($sistemasKpi->pluck('percentage')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }, {
                label: 'Umbral',
                data: {!! json_encode($sistemasThresholds->pluck('value')) !!},
                type: 'line',
                borderColor: '#ED3236',
                borderWidth: 2,
                fill: false
            }]
        },
        options: chartOptions
    });

    // Reemplazar la configuración del gráfico comparativo
    new Chart(document.getElementById('comparativeChart'), {
        type: 'line',
        data: {
            labels: ['Enfermería', 'Compras', 'RRHH', 'Sistemas'],
            datasets: [{
                label: 'Promedio Real',
                data: [
                    {{ $enfermeriaAnalysis['avg_percentage'] }},
                    {{ $comprasAnalysis['avg_percentage'] }},
                    {{ $rrhhAnalysis['avg_percentage'] }},
                    {{ $sistemasAnalysis['avg_percentage'] }}
                ],
                borderColor: 'rgba(54, 78, 118, 1)',
                backgroundColor: 'rgba(54, 78, 118, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }, {
                label: 'Umbral Esperado',
                data: [
                    {{ $enfermeriaAnalysis['avg_threshold'] }},
                    {{ $comprasAnalysis['avg_threshold'] }},
                    {{ $rrhhAnalysis['avg_threshold'] }},
                    {{ $sistemasAnalysis['avg_threshold'] }}
                ],
                borderColor: 'rgba(237, 50, 54, 1)',
                backgroundColor: 'rgba(237, 50, 54, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            }
        }
    });
});
</script>
@stop