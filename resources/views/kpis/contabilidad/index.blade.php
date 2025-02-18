@extends('adminlte::page')

@section('title', 'KPIs - Contabilidad')

@section('content_header')
    <h1>KPIs - Contabilidad</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Month Filter -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="float-right">
                <form method="GET" action="{{ route('kpis.contabilidad.index') }}" class="form-inline">
                    <label for="month" class="mr-2">Filtrar por Mes:</label>
                    <select name="month" id="month" class="form-control select2bs4" onchange="this.form.submit()">
                        <option value="">Todos los meses</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- KPIs de Medición -->
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">KPIs de Medición</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="measurement-kpis-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
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
                            <td>{{ $kpi->name }}</td>
                            <td>{{ $kpi->methodology }}</td>
                            <td>{{ $kpi->frequency }}</td>
                            <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                            <td>{{ $kpi->percentage }}%</td>
                            <td>
                                <span class="badge {{ $kpi->status == 'Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $kpi->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('kpis.contabilidad.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Análisis Estadístico KPIs de Medición -->
            <div class="mt-4">
                <h4>Análisis Estadístico - KPIs de Medición</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Media</span>
                                <span class="info-box-number">{{ number_format($measurementStats['average'], 2) }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-chart-bar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Mediana</span>
                                <span class="info-box-number">{{ number_format($measurementStats['median'], 2) }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-chart-pie"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Desviación Estándar</span>
                                <span class="info-box-number">{{ number_format($measurementStats['stdDev'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-exclamation-triangle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bajo Umbral</span>
                                <span class="info-box-number">{{ $measurementStats['countUnder'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    {{ $measurementStats['conclusion'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs Informativos -->
    <div class="card mt-4">
        <div class="card-header bg-secondary">
            <h3 class="card-title">KPIs Informativos</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="informative-kpis-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
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
                            <td>{{ $kpi->name }}</td>
                            <td>{{ $kpi->methodology }}</td>
                            <td>{{ $kpi->frequency }}</td>
                            <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                            <td>{{ $kpi->percentage }}%</td>
                            <td>
                                <span class="badge {{ $kpi->status == 'Favorable' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $kpi->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('kpis.contabilidad.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Análisis Estadístico KPIs Informativos -->
            <div class="mt-4">
                <h4>Análisis Estadístico - KPIs Informativos</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-chart-line"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Media</span>
                                <span class="info-box-number">{{ number_format($informativeStats['average'], 2) }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-chart-bar"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Mediana</span>
                                <span class="info-box-number">{{ number_format($informativeStats['median'], 2) }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-chart-pie"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Desviación Estándar</span>
                                <span class="info-box-number">{{ number_format($informativeStats['stdDev'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    {{ $informativeStats['conclusion'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico Comparativo -->
    <div class="card mt-4">
        <div class="card-header bg-dark">
            <h3 class="card-title">Gráfico Comparativo de KPIs</h3>
        </div>
        <div class="card-body">
            <canvas id="kpiChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
.card-header {
    background-color: #39446D !important;
    color: white !important;
}
.btn-primary {
    background-color: #39446D;
    border-color: #39446D;
}
.btn-primary:hover {
    background-color: #2c3356;
    border-color: #2c3356;
}
.page-item.active .page-link {
    background-color: #39446D;
    border-color: #39446D;
}
.info-box-icon {
    background-color: #39446D !important;
    color: white !important;
}
.select2-container--bootstrap4 .select2-results__option--highlighted {
    background-color: #39446D !important;
}
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
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

    const meses = {
        1: 'Enero',
        2: 'Febrero',
        3: 'Marzo',
        4: 'Abril',
        5: 'Mayo',
        6: 'Junio',
        7: 'Julio',
        8: 'Agosto',
        9: 'Septiembre',
        10: 'Octubre',
        11: 'Noviembre',
        12: 'Diciembre'
    };

    $('#month').html(`
        <option value="">Todos los meses</option>
        ${Object.entries(meses).map(([num, nombre]) => 
            `<option value="${num}" ${request('month') == num ? 'selected' : ''}>${nombre}</option>`
        ).join('')}
    `);

    // Inicializar DataTables
    $('#measurement-kpis-table, #informative-kpis-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Eliminar KPI
    $('.delete-kpi').click(function() {
        const kpiId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/kpis/contabilidad/${kpiId}`,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al eliminar el KPI.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Gráfico
    const ctx = document.getElementById('kpiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'KPIs de Medición',
                data: {!! json_encode($chartData['measurementData']) !!},
                backgroundColor: 'rgba(60, 141, 188, 0.5)',
                borderColor: 'rgba(60, 141, 188, 1)',
                borderWidth: 1
            },
            {
                label: 'KPIs Informativos',
                data: {!! json_encode($chartData['informativeData']) !!},
                backgroundColor: 'rgba(210, 214, 222, 0.5)',
                borderColor: 'rgba(210, 214, 222, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
});
</script>
@stop