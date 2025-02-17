@extends('adminlte::page')

@section('title', 'KPIs - Recursos Humanos')

@section('content_header')
    <h1>Listado de KPIs - Recursos Humanos</h1>
@stop

@section('content')
<!-- KPIs de Medición -->
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">KPIs de Medición</h3>
    </div>
    <div class="card-body">
        <table id="measurementTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del KPI</th>
                    <th>Metodología</th>
                    <th>Frecuencia</th>
                    <th>Fecha</th>
                    <th>Porcentaje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($measurementKpis as $kpi)
                <tr>
                    <td>{{ $kpi->id }}</td>
                    <td>{{ $kpi->name }}</td>
                    <td>{{ $kpi->methodology }}</td>
                    <td>{{ $kpi->frequency }}</td>
                    <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                    <td>{{ number_format($kpi->percentage, 2) }}%</td>
                    <td>
                        <span class="badge {{ $kpi->status == 'Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                            {{ $kpi->status }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('kpis.rrhh.show', $kpi->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('kpis.rrhh.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
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

<!-- KPIs Informativos -->
<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h3 class="card-title">KPIs Informativos</h3>
    </div>
    <div class="card-body">
        <table id="informativeTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del KPI</th>
                    <th>Metodología</th>
                    <th>Frecuencia</th>
                    <th>Fecha</th>
                    <th>Porcentaje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informativeKpis as $kpi)
                <tr>
                    <td>{{ $kpi->id }}</td>
                    <td>{{ $kpi->name }}</td>
                    <td>{{ $kpi->methodology }}</td>
                    <td>{{ $kpi->frequency }}</td>
                    <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                    <td>{{ number_format($kpi->percentage, 2) }}%</td>
                    <td>
                        <span class="badge {{ $kpi->status == 'Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                            {{ $kpi->status }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('kpis.rrhh.show', $kpi->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('kpis.rrhh.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
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

<!-- Análisis Estadístico -->
<div class="card mt-4">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">Análisis Estadístico</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Media</span>
                        <span class="info-box-number">{{ number_format($average, 2) }}%</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-sort-numeric-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mediana</span>
                        <span class="info-box-number">{{ number_format($median, 2) }}%</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-chart-bar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Desviación Estándar</span>
                        <span class="info-box-number">{{ number_format($stdDev, 2) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-arrow-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Valor Máximo</span>
                        <span class="info-box-number">{{ number_format($max, 2) }}%</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-arrow-down"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Valor Mínimo</span>
                        <span class="info-box-number">{{ number_format($min, 2) }}%</span>
                    </div>
                </div>
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">KPIs bajo el umbral</span>
                        <span class="info-box-number">{{ $countUnder }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info mt-3">
            <h5><i class="icon fas fa-info"></i> Conclusión del Análisis</h5>
            {{ $conclusion }}
        </div>

        <div class="chart-container mt-4" style="position: relative; height:400px;">
            <canvas id="kpiChart"></canvas>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
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
    $('#measurementTable, #informativeTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Inicializar Select2
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Configuración del gráfico
    const ctx = document.getElementById('kpiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_merge(
                $measurementKpis->pluck('name')->toArray(),
                $informativeKpis->pluck('name')->toArray()
            )) !!},
            datasets: [{
                label: 'KPIs de Medición',
                data: {!! json_encode($measurementKpis->pluck('percentage')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'KPIs Informativos',
                data: {!! json_encode($informativeKpis->pluck('percentage')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
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

    // Manejo de eliminación
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
                    url: `/rrhh/kpis/${kpiId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            '¡Eliminado!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el KPI',
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