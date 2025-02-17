@extends('adminlte::page')

@section('title', 'Ver KPI - Enfermería')

@section('content_header')
    <h1>Listado de KPIs - Enfermería</h1>
@stop

@section('content')
<!-- Sección de KPIs de Medición -->
<div class="card">
    <div class="card-header">
        <div class="float-right">
            <form method="GET" action="{{ route('kpis.enfermeria.index') }}" class="form-inline">
                <label for="month" class="mr-2">Filtrar por Mes:</label>
                <select name="month" id="month" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </form>
        </div>
        <h3 class="card-title"><b>KPIs de Medición</b></h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table id="measurementTable" class="table table-bordered table-striped">
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
                            <a href="{{ route('kpis.enfermeria.show', $kpi->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('kpis.enfermeria.edit', $kpi->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Sección de KPIs Informativos -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title"><b>KPIs Informativos</b></h3>
    </div>
    <div class="card-body">
        <table id="informativeTable" class="table table-bordered table-striped">
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
                            <a href="{{ route('kpis.enfermeria.show', $kpi->id) }}" class="btn btn-sm btn-info">Ver</a>
                            <a href="{{ route('kpis.enfermeria.edit', $kpi->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Sección de análisis estadístico -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Análisis Estadístico de KPIs</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>Estadísticas Generales</h4>
                <p><strong>Media General:</strong> {{ number_format($average, 2) }}%</p>
                <p><strong>Mediana:</strong> {{ number_format($median, 2) }}%</p>
                <p><strong>Desviación Estándar:</strong> {{ number_format($stdDev, 2) }}</p>
                <p><strong>Coeficiente de Variación:</strong> {{ number_format($coefficientOfVariation, 2) }}%</p>
            </div>
            <div class="col-md-6">
                <h4>Indicadores de Rendimiento</h4>
                <p><strong>Valor Máximo:</strong> {{ number_format($max, 2) }}%</p>
                <p><strong>Valor Mínimo:</strong> {{ number_format($min, 2) }}%</p>
                <p><strong>Rango:</strong> {{ number_format($range, 2) }}%</p>
                <p><strong>KPIs por debajo del umbral:</strong> {{ $countUnder }} ({{ number_format($percentageUnder, 2) }}%)</p>
            </div>
        </div>
        
        <div class="mt-4">
            <h4>Análisis por Tipo de KPI</h4>
            <div class="row">
                <div class="col-md-6">
                    <h5>KPIs de Medición</h5>
                    <p><strong>Media:</strong> {{ number_format($measurementStats['average'], 2) }}%</p>
                    <p><strong>Por debajo del umbral:</strong> {{ $measurementStats['countUnder'] }} de {{ $measurementStats['total'] }}</p>
                </div>
                <div class="col-md-6">
                    <h5>KPIs Informativos</h5>
                    <p><strong>Media:</strong> {{ number_format($informativeStats['average'], 2) }}%</p>
                    <p><strong>Por debajo del umbral:</strong> {{ $informativeStats['countUnder'] }} de {{ $informativeStats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h4>Conclusión del Análisis</h4>
            <p class="text-justify">{{ $conclusion }}</p>
        </div>

        <div class="mt-4">
            <canvas id="kpiChart" style="height:400px;"></canvas>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<style>
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    }
</style>
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Inicializar DataTables
    $('#measurementTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });
    
    $('#informativeTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Configuración del gráfico
    var ctx = document.getElementById('kpiChart').getContext('2d');
    var measurementData = {!! json_encode($kpis->where('type', 'measurement')->pluck('percentage')) !!};
    var informativeData = {!! json_encode($kpis->where('type', 'informative')->pluck('percentage')) !!};
    var labels = {!! json_encode($kpis->pluck('name')) !!};
    
    var kpiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'KPIs de Medición',
                    data: measurementData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'KPIs Informativos',
                    data: informativeData,
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
                },
                x: {
                    title: {
                        display: true,
                        text: 'KPIs'
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
    $('.delete-kpi').click(function(){
        var kpiId = $(this).data('id');
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
                    url: '/enfermeria/kpis/' + kpiId,
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