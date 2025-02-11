@extends('adminlte::page')

@section('title', 'Dashboard Biométrico')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Dashboard Biométrico - {{ $mes }}</h1>
        <div class="form-group mb-0">
            <select id="mes-selector" class="form-control" onchange="cambiarMes(this.value)">
                <option value="actual" {{ $mes == 'actual' ? 'selected' : '' }}>Seleccionar mes...</option>
                <option value="Enero" {{ $mes == 'Enero' ? 'selected' : '' }}>Enero</option>
                <option value="Febrero" {{ $mes == 'Febrero' ? 'selected' : '' }}>Febrero</option>
                <option value="Marzo" {{ $mes == 'Marzo' ? 'selected' : '' }}>Marzo</option>
                <option value="Abril" {{ $mes == 'Abril' ? 'selected' : '' }}>Abril</option>
                <option value="Mayo" {{ $mes == 'Mayo' ? 'selected' : '' }}>Mayo</option>
                <option value="Junio" {{ $mes == 'Junio' ? 'selected' : '' }}>Junio</option>
                <option value="Julio" {{ $mes == 'Julio' ? 'selected' : '' }}>Julio</option>
                <option value="Agosto" {{ $mes == 'Agosto' ? 'selected' : '' }}>Agosto</option>
                <option value="Septiembre" {{ $mes == 'Septiembre' ? 'selected' : '' }}>Septiembre</option>
                <option value="Octubre" {{ $mes == 'Octubre' ? 'selected' : '' }}>Octubre</option>
                <option value="Noviembre" {{ $mes == 'Noviembre' ? 'selected' : '' }}>Noviembre</option>
                <option value="Diciembre" {{ $mes == 'Diciembre' ? 'selected' : '' }}>Diciembre</option>
            </select>
        </div>
    </div>
@stop

@section('content')
@if($records->isEmpty())
    <div class="alert alert-warning">
        No hay registros disponibles para el mes de {{ $mes }}.
    </div>
@else
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalEmployees }}</h3>
                    <p>Total Empleados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $averageAttendance }}%</h3>
                    <p>Asistencia Promedio</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $lateArrivalsCount }}</h3>
                    <p>Llegadas Tarde</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $absences['total'] }}</h3>
                    <p>Ausencias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Tendencia Semanal -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tendencia Semanal</h3>
                </div>
                <div class="card-body">
                    <canvas id="weeklyTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico por Departamentos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Asistencia por Departamentos</h3>
                </div>
                <div class="card-body">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Llegadas Tarde por Hora -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Llegadas Tarde por Hora</h3>
                </div>
                <div class="card-body">
                    <canvas id="lateArrivalsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla de Análisis por Departamento -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Análisis por Departamento</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Total</th>
                                    <th>A Tiempo</th>
                                    <th>Tarde</th>
                                    <th>Tasa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departmentStats as $dept => $stats)
                                <tr>
                                    <td>{{ $dept }}</td>
                                    <td>{{ $stats['total'] }}</td>
                                    <td>{{ $stats['onTime'] }}</td>
                                    <td>{{ $stats['late'] }}</td>
                                    <td>{{ $stats['attendanceRate'] }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Asistencia</h3>
        </div>
        <div class="card-body">
            <table id="attendance-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Departamento</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                    <tr>
                        <td>{{ $record->no_id }}</td>
                        <td>{{ $record->nombre_apellidos }}</td>
                        <td>{{ $record->fecha ? Carbon\Carbon::parse($record->fecha)->format('d-m-Y') : 'N/A' }}</td>
                        <td>{{ $record->entrada ?: 'No registrado' }}</td>
                        <td>{{ $record->salida ?: 'No registrado' }}</td>
                        <td>{{ $record->departamento }}</td>
                        <td>
                            @if(empty($record->entrada))
                                <span class="badge badge-danger">Ausente</span>
                            @else
                                @php
                                    try {
                                        // Intentar varios formatos de hora
                                        $entrada = null;
                                        $horaStr = $record->entrada;
                                        
                                        $formatos = ['H:i:s', 'H:i', 'h:i:s A', 'h:i A'];
                                        
                                        foreach ($formatos as $formato) {
                                            try {
                                                $entrada = Carbon\Carbon::createFromFormat($formato, $horaStr);
                                                break;
                                            } catch (\Exception $e) {
                                                continue;
                                            }
                                        }
                                        
                                        if (!$entrada) {
                                            $entrada = Carbon\Carbon::parse($horaStr);
                                        }
                                        
                                        $limite = Carbon\Carbon::createFromFormat('H:i', '07:00');
                                    } catch (\Exception $e) {
                                        $entrada = null;
                                    }
                                @endphp
                                
                                @if(!$entrada)
                                    <span class="badge badge-danger">Ausente</span>
                                @elseif($entrada->gt($limite))
                                    <span class="badge badge-warning">Tarde</span>
                                @else
                                    <span class="badge badge-success">A tiempo</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@stop

@section('js')
<script>
function cambiarMes(mes) {
    if (mes) {
        window.location.href = '{{ url("attendance/dashboard") }}/' + mes;
    }
}

$(document).ready(function() {
    // Add custom filter dropdown
    var statusFilter = '<select id="status-filter" class="form-control"><option value="">Todos</option><option value="A tiempo">A tiempo</option><option value="Tarde">Tarde</option><option value="Ausente">Ausente</option></select>';
    
    var table = $('#attendance-table').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "dom": '<"row"<"col-sm-3"l><"col-sm-6"<"#status-filter-container">><"col-sm-3"f>>rtip',
        "initComplete": function() {
            $("#status-filter-container").html(statusFilter);
            
            // Custom filtering function
            $('#status-filter').on('change', function() {
                var selectedStatus = $(this).val();
                table.column(6).search(selectedStatus).draw();
            });
        }
    });

    // Add custom filter for each column if needed
    table.columns().every(function() {
        var column = this;
        if ($(column.header()).text() === 'Estado') {
            // Already handled by the custom dropdown
            return;
        }
    });
});

// Configuración de gráficos
const weekDays = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// Gráfico de Tendencia Semanal
new Chart(document.getElementById('weeklyTrendChart'), {
    type: 'line',
    data: {
        labels: weekDays,
        datasets: [{
            label: 'A Tiempo',
            data: @json(array_values(array_map(function($day) { return $day['onTime']; }, $weeklyTrends->toArray()))),
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false
        }, {
            label: 'Tarde',
            data: @json(array_values(array_map(function($day) { return $day['late']; }, $weeklyTrends->toArray()))),
            borderColor: 'rgba(255, 99, 132, 1)',
            fill: false
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Gráfico por Departamentos
new Chart(document.getElementById('departmentChart'), {
    type: 'bar',
    data: {
        labels: @json(array_keys($departmentStats->toArray())),
        datasets: [{
            label: 'A Tiempo',
            data: @json($departmentStats->pluck('onTime')),
            backgroundColor: 'rgba(75, 192, 192, 0.5)'
        }, {
            label: 'Tarde',
            data: @json($departmentStats->pluck('late')),
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                stacked: true
            },
            x: {
                stacked: true
            }
        }
    }
});

// Gráfico de Llegadas Tarde por Hora
new Chart(document.getElementById('lateArrivalsChart'), {
    type: 'bar',
    data: {
        labels: Object.keys(@json($lateArrivalsHours)),
        datasets: [{
            label: 'Cantidad',
            data: Object.values(@json($lateArrivalsHours)),
            backgroundColor: 'rgba(255, 159, 64, 0.5)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@stop
