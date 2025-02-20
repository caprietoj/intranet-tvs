@extends('adminlte::page')

@section('title', 'Dashboard de KPIs')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dashboard de Indicadores de Gestión</h1>
        <select id="monthFilter" class="form-control" style="width: 200px;">
            <option value="">Todos los meses</option>
            @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $mes)
                <option value="{{ $mes }}">{{ $mes }}</option>
            @endforeach
        </select>
    </div>
@stop

@section('content')
    @if(isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @else
        <!-- Tarjetas de Análisis -->
        <div class="row">
            <!-- Enfermería -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="enfermeriaPercentage">{{ number_format($enfermeriaAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs Enfermería</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ $enfermeriaAnalysis['status'] }}
                    </div>
                </div>
            </div>

            <!-- Compras -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="comprasPercentage">{{ number_format($comprasAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs Compras</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ $comprasAnalysis['status'] }}
                    </div>
                </div>
            </div>

            <!-- RRHH -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="rrhhPercentage">{{ number_format($rrhhAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs RRHH</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ $rrhhAnalysis['status'] }}
                    </div>
                </div>
            </div>

            <!-- Sistemas -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="sistemasPercentage">{{ number_format($sistemasAnalysis['avg_percentage'], 1) }}%</h3>
                        <p>Promedio KPIs Sistemas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ $sistemasAnalysis['status'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row mt-4">
            <!-- Gráfico de Tendencias -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tendencia de KPIs por Área</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="trendChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Comparación -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Comparación con Umbrales</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="thresholdChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tablas de KPIs -->
        <div class="row">
            @foreach([
                'enfermeria' => ['title' => 'Enfermería', 'data' => $kpis, 'thresholds' => $enfermeriaThresholds],
                'compras' => ['title' => 'Compras', 'data' => $comprasKpis, 'thresholds' => $comprasThresholds],
                'rrhh' => ['title' => 'Recursos Humanos', 'data' => $recursosKpi, 'thresholds' => $rrhhThresholds],
                'sistemas' => ['title' => 'Sistemas', 'data' => $sistemasKpi, 'thresholds' => $sistemasThresholds]
            ] as $key => $section)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">KPIs {{ $section['title'] }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" data-area="{{ $key }}">
                                    <thead>
                                        <tr>
                                            <th>KPI</th>
                                            <th>Valor Actual</th>
                                            <th>Umbral</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($section['data'] as $kpi)
                                            <tr>
                                                <td>{{ $kpi->name }}</td>
                                                <td>{{ number_format($kpi->percentage, 1) }}%</td>
                                                <td>
                                                    @php
                                                        $threshold = $section['thresholds']->where('kpi_name', $kpi->name)->first();
                                                    @endphp
                                                    {{ $threshold ? number_format($threshold->value, 1) . '%' : 'N/A' }}
                                                </td>
                                                <td>
                                                    @if($threshold)
                                                        @if($kpi->percentage >= $threshold->value)
                                                            <span class="badge badge-success">Alcanzado</span>
                                                        @else
                                                            <span class="badge badge-danger">No Alcanzado</span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-warning">Sin Umbral</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@stop

@section('css')
<style>
    .small-box { transition: all .3s ease; }
    .small-box:hover { transform: translateY(-3px); }
    .table td, .table th { vertical-align: middle; }
    .badge { font-size: 0.9em; padding: 0.5em 0.75em; }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Configuración inicial de DataTables
    let tables = $('.table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "pageLength": 10,
        "order": [[0, "asc"]]
    });

    // Inicializar gráficos
    const trendChart = new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [
                {
                    label: 'Enfermería',
                    data: {!! json_encode($kpis->pluck('percentage')) !!},
                    borderColor: '#17a2b8',
                    fill: false
                },
                {
                    label: 'Compras',
                    data: {!! json_encode($comprasKpis->pluck('percentage')) !!},
                    borderColor: '#28a745',
                    fill: false
                },
                {
                    label: 'RRHH',
                    data: {!! json_encode($recursosKpi->pluck('percentage')) !!},
                    borderColor: '#ffc107',
                    fill: false
                },
                {
                    label: 'Sistemas',
                    data: {!! json_encode($sistemasKpi->pluck('percentage')) !!},
                    borderColor: '#dc3545',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    const thresholdChart = new Chart(document.getElementById('thresholdChart'), {
        type: 'bar',
        data: {
            labels: ['Enfermería', 'Compras', 'RRHH', 'Sistemas'],
            datasets: [
                {
                    label: 'Valor Actual',
                    data: [
                        {{ $enfermeriaAnalysis['avg_percentage'] }},
                        {{ $comprasAnalysis['avg_percentage'] }},
                        {{ $rrhhAnalysis['avg_percentage'] }},
                        {{ $sistemasAnalysis['avg_percentage'] }}
                    ],
                    backgroundColor: ['#17a2b8', '#28a745', '#ffc107', '#dc3545']
                },
                {
                    label: 'Umbral',
                    data: [
                        {{ $enfermeriaAnalysis['avg_threshold'] }},
                        {{ $comprasAnalysis['avg_threshold'] }},
                        {{ $rrhhAnalysis['avg_threshold'] }},
                        {{ $sistemasAnalysis['avg_threshold'] }}
                    ],
                    type: 'line',
                    borderColor: '#6c757d',
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Filtrado por mes
    $('#monthFilter').change(function() {
        let selectedMonth = $(this).val();
        
        // Actualizar datos vía AJAX
        $.ajax({
            url: '{{ route("kpi-report.index") }}',
            data: { month: selectedMonth },
            success: function(response) {
                // Actualizar gráficos
                updateCharts(response);
                // Actualizar tablas
                updateTables(response);
                // Actualizar tarjetas de análisis
                updateAnalysisCards(response);
            }
        });
    });
});

function updateCharts(data) {
    // Actualizar datos de los gráficos
    trendChart.data.datasets[0].data = data.kpis;
    trendChart.data.datasets[1].data = data.comprasKpis;
    trendChart.data.datasets[2].data = data.recursosKpi;
    trendChart.data.datasets[3].data = data.sistemasKpi;
    trendChart.update();

    thresholdChart.data.datasets[0].data = [
        data.enfermeriaAnalysis.avg_percentage,
        data.comprasAnalysis.avg_percentage,
        data.rrhhAnalysis.avg_percentage,
        data.sistemasAnalysis.avg_percentage
    ];
    thresholdChart.update();
}

function updateTables(data) {
    // Actualizar contenido de las tablas
    $('.table').each(function() {
        let table = $(this).DataTable();
        table.clear().rows.add(data[$(this).data('area')]).draw();
    });
}

function updateAnalysisCards(data) {
    // Actualizar valores en las tarjetas
    $('#enfermeriaPercentage').text(data.enfermeriaAnalysis.avg_percentage.toFixed(1) + '%');
    $('#comprasPercentage').text(data.comprasAnalysis.avg_percentage.toFixed(1) + '%');
    $('#rrhhPercentage').text(data.rrhhAnalysis.avg_percentage.toFixed(1) + '%');
    $('#sistemasPercentage').text(data.sistemasAnalysis.avg_percentage.toFixed(1) + '%');
}
</script>
@stop
