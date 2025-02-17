@extends('adminlte::page')

@section('title', 'Ver KPI - Sistemas')

@section('content_header')
    <h1>Listado de KPIs - Sistemas</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
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
                            <th>Fecha de Medición</th>
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
                            <td>{{ $kpi->percentage }}%</td>
                            <td>
                                <span class="badge {{ $kpi->status == 'Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $kpi->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('kpis.sistemas.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
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
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
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
                            <th>Fecha de Medición</th>
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
                            <td>{{ $kpi->percentage }}%</td>
                            <td>
                                <span class="badge {{ $kpi->status == 'Favorable' ? 'badge-success' : 'badge-danger' }}">
                                    {{ $kpi->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('kpis.sistemas.edit', $kpi->id) }}" class="btn btn-sm btn-primary">
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
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">Análisis Estadístico</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>KPIs de Medición</h4>
                        <p><strong>Media:</strong> {{ number_format($measurementStats['average'], 2) }}%</p>
                        <p><strong>Mediana:</strong> {{ number_format($measurementStats['median'], 2) }}%</p>
                        <p><strong>Desviación Estándar:</strong> {{ number_format($measurementStats['stdDev'], 2) }}</p>
                        <p><strong>KPIs por debajo del umbral:</strong> {{ $measurementStats['countUnder'] }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>KPIs Informativos</h4>
                        <p><strong>Media:</strong> {{ number_format($informativeStats['average'], 2) }}%</p>
                        <p><strong>Mediana:</strong> {{ number_format($informativeStats['median'], 2) }}%</p>
                        <p><strong>Desviación Estándar:</strong> {{ number_format($informativeStats['stdDev'], 2) }}</p>
                        <p><strong>KPIs Desfavorables:</strong> {{ $informativeStats['countUnder'] }}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <canvas id="kpiChart" style="height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('#measurementTable, #informativeTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    // Configuración del gráfico
    var ctx = document.getElementById('kpiChart').getContext('2d');
    var kpiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'KPIs de Medición',
                data: {!! json_encode($chartData['measurementData']) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'KPIs Informativos',
                data: {!! json_encode($chartData['informativeData']) !!},
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
                    max: 100
                }
            }
        }
    });

    // Manejo de eliminación
    $('.delete-kpi').click(function(){
        var kpiId = $(this).data('id');
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
                    url: '/sistemas/kpis/' + kpiId,
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