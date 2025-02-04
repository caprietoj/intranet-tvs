@extends('adminlte::page')

@section('title', 'Ver KPI - Sistemas')

@section('content_header')
    <h1>Listado de KPIs - Sistemas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-right">
            <form method="GET" action="{{ route('kpis.sistemas.index') }}" class="form-inline">
                <label for="month" class="mr-2">Filtrar por Mes:</label>
                <select name="month" id="month" class="form-control mr-2" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ request('month')==$m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endfor
                </select>
            </form>
        </div>
        <h3 class="card-title">KPIs Registrados</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
           <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table id="kpiTable" class="table table-bordered table-striped">
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
                @foreach($kpis as $kpi)
                <tr>
                    <td>{{ $kpi->id }}</td>
                    <td>{{ $kpi->name }}</td>
                    <td>{{ $kpi->methodology }}</td>
                    <td>{{ $kpi->frequency }}</td>
                    <td>{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</td>
                    <td>{{ $kpi->percentage }}%</td>
                    <td>
                        <span class="badge {{ $kpi->status=='Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                           {{ $kpi->status }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('kpis.sistemas.show', $kpi->id) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('kpis.sistemas.edit', $kpi->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <button class="btn btn-sm btn-danger delete-kpi" data-id="{{ $kpi->id }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Análisis Estadístico</h3>
    </div>
    <div class="card-body">
        <div class="row">
           <div class="col-md-6">
               <p><strong>Media:</strong> {{ number_format($average,2) }}%</p>
               <p><strong>Mediana:</strong> {{ number_format($median,2) }}%</p>
               <p><strong>Desviación Estándar:</strong> {{ number_format($stdDev,2) }}</p>
           </div>
           <div class="col-md-6">
               <p><strong>Valor Máximo:</strong> {{ $max }}%</p>
               <p><strong>Valor Mínimo:</strong> {{ $min }}%</p>
               <p><strong>KPIs por debajo del umbral:</strong> {{ $countUnder }}</p>
           </div>
        </div>
        <p><strong>Conclusión:</strong> {{ $conclusion }}</p>
        <canvas id="kpiChart" style="height:300px;"></canvas>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('#kpiTable').DataTable();
    var labels = {!! json_encode($kpis->pluck('name')) !!};
    var dataPercentages = {!! json_encode($kpis->pluck('percentage')) !!};
    var ctx = document.getElementById('kpiChart').getContext('2d');
    var kpiChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Porcentaje Alcanzado',
                data: dataPercentages,
                backgroundColor: 'rgba(54,162,235,0.5)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        }
    });

    $('.delete-kpi').click(function(){
        var kpiId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el KPI.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/sistemas/kpis/' + kpiId,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response){
                        Swal.fire('Eliminado!', response.message, 'success').then(()=>{
                            location.reload();
                        });
                    },
                    error: function(){
                        Swal.fire('Error!', 'No se pudo eliminar el KPI.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@stop
