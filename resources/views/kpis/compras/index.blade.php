@extends('adminlte::page')

@section('title', 'KPIs Compras')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary">KPIs - Compras</h1>
        <a href="{{ route('kpis.compras.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo KPI
        </a>
    </div>
@stop

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="float-right">
            <form method="GET" action="{{ route('kpis.compras.index') }}" class="form-inline">
                <label for="month" class="mr-2">Filtrar por Mes:</label>
                <select name="month" id="month" class="form-control select2bs4" onchange="this.form.submit()">
                    <option value="">Todos los meses</option>
                    @php
                        $meses = [
                            1 => 'Enero',
                            2 => 'Febrero',
                            3 => 'Marzo',
                            4 => 'Abril',
                            5 => 'Mayo',
                            6 => 'Junio',
                            7 => 'Julio',
                            8 => 'Agosto',
                            9 => 'Septiembre',
                            10 => 'Octubre',
                            11 => 'Noviembre',
                            12 => 'Diciembre'
                        ];
                    @endphp
                    @foreach($meses as $num => $nombre)
                        <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</div>

<!-- KPIs de Medición -->
<div class="card custom-card">
    <div class="card-header bg-primary">
        <h3 class="card-title text-white">KPIs de Medición</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="measurementKpiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del KPI</th>
                        <th>Metodología</th>
                        <th>Frecuencia</th>
                        <th>Fecha de Medición</th>
                        <th>Porcentaje</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpis->where('type', 'measurement') as $kpi)
                    <tr>
                        <td>{{ $kpi->id }}</td>
                        <td>{{ $kpi->threshold->kpi_name }}</td>
                        <td>{{ $kpi->methodology }}</td>
                        <td>{{ $kpi->frequency }}</td>
                        <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                        <td>{{ $kpi->percentage }}%</</td>
                        <td>
                            @php
                                $thresholdValue = $kpi->threshold ? $kpi->threshold->value : 80;
                                $status = $kpi->percentage >= $thresholdValue ? 'Alcanzado' : 'No Alcanzado';
                            @endphp
                            <span class="badge {{ $status == 'Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('kpis.compras.show', $kpi->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kpis.compras.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- KPIs Informativos -->
<div class="card custom-card mt-4">
    <div class="card-header bg-info">
        <h3 class="card-title text-white">KPIs Informativos</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="informativeKpiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del KPI</th>
                        <th>Metodología</th>
                        <th>Frecuencia</th>
                        <th>Fecha de Medición</th>
                        <th>Porcentaje</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpis->where('type', 'informative') as $kpi)
                    <tr>
                        <td>{{ $kpi->id }}</td>
                        <td>{{ $kpi->threshold->kpi_name }}</td>
                        <td>{{ $kpi->methodology }}</td>
                        <td>{{ $kpi->frequency }}</td>
                        <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                        <td>{{ $kpi->percentage }}%</</td>
                        <td>
                            @php
                                $thresholdValue = $kpi->threshold ? $kpi->threshold->value : 80;
                                $status = $kpi->percentage >= $thresholdValue ? 'Alcanzado' : 'No Alcanzado';
                            @endphp
                            <span class="badge {{ $status == 'Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('kpis.compras.show', $kpi->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kpis.compras.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Análisis Estadístico -->
<div class="card custom-card mt-4">
    <div class="card-header bg-success">
        <h3 class="card-title text-white">Análisis Estadístico</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Estadísticas Generales</span>
                        <span class="info-box-number">Media: {{ number_format($average, 2) }}%</span>
                        <span class="info-box-number">Mediana: {{ number_format($median, 2) }}%</span>
                        <span class="info-box-number">Desviación Estándar: {{ number_format($stdDev, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-chart-bar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Valores Extremos</span>
                        <span class="info-box-number">Máximo: {{ $max }}%</span>
                        <span class="info-box-number">Mínimo: {{ $min }}%</span>
                        <span class="info-box-number">KPIs bajo umbral: {{ $countUnder }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Comparativa de KPIs</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="kpiChart" style="min-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <h5><i class="icon fas fa-info"></i> Conclusión del Análisis</h5>
            <p>{{ $conclusion }}</p>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    :root {
        --primary: #1a4884;
        --secondary: #6c757d;
        --success: #28a745;
        --danger: #dc3545;
        --info: #17a2b8;
        --warning: #ffc107;
        --border-radius: 8px;
        --box-shadow: 0 2px 4px rgba(0,0,0,.08);
    }

    .text-primary {
        color: var(--primary) !important;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .custom-card {
        background: #ffffff;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        margin-bottom: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,.12);
    }

    .card-header {
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        padding: 1.5rem;
    }

    .bg-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%) !important;
    }

    .bg-info {
        background: linear-gradient(135deg, var(--info) 0%, #36b9cc 100%) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, var(--success) 0%, #2dce89 100%) !important;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        border-top: none;
        background: rgba(0,0,0,.05);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 20px;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .badge-danger {
        background: linear-gradient(135deg, #dc3545 0%, #f86384 100%);
    }

    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
    }

    .btn-group .btn {
        margin: 0 0.2rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(26, 72, 132, 0.25);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a5298 0%, var(--primary) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 72, 132, 0.35);
    }

    .info-box {
        background: #ffffff;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--box-shadow);
        transition: transform 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    .info-box-icon {
        border-radius: var(--border-radius);
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .alert-info {
        background: linear-gradient(135deg, #17a2b8 0%, #36b9cc 100%);
        border: none;
        color: white;
    }

    .select2-container--bootstrap4 .select2-selection {
        border: 2px solid #e9ecef;
        border-radius: 6px;
        min-height: 45px;
        padding: 0.5rem;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
        border-radius: 6px;
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Inicializar DataTables
    $('#measurementKpiTable, #informativeKpiTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Inicializar Select2
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%',
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            }
        }
    });

    // Configuración del gráfico
    var ctx = document.getElementById('kpiChart').getContext('2d');
    var measurementKpis = {!! json_encode($kpis->where('type', 'measurement')->pluck('percentage', 'name')) !!};
    var informativeKpis = {!! json_encode($kpis->where('type', 'informative')->pluck('percentage', 'name')) !!};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [...Object.keys(measurementKpis), ...Object.keys(informativeKpis)],
            datasets: [
                {
                    label: 'KPIs de Medición',
                    data: Object.values(measurementKpis),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'KPIs Informativos',
                    data: Object.values(informativeKpis),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Porcentaje (%)'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Comparativa de KPIs por Tipo'
                }
            }
        }
    });

    // Manejo de eliminación de KPIs
    $('.delete-kpi').click(function() {
        const kpiId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/compras/kpis/${kpiId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El KPI ha sido eliminado.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el KPI.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
@stop