{{-- resources/views/threshold/rrhh/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Ver Umbrales Configurados - Recursos Humanos')

@section('content_header')
    <h1>Umbrales Configurados - Recursos Humanos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table id="thresholdTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del KPI</th>
                    <th>Valor del Threshold (%)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($thresholds as $threshold)
                <tr>
                    <td>{{ $threshold->id }}</td>
                    <td>{{ $threshold->kpi_name }}</td>
                    <td>{{ $threshold->value }}</td>
                    <td>
                        <a href="{{ route('umbral.rrhh.edit', $threshold->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <button class="btn btn-sm btn-danger delete-threshold" data-id="{{ $threshold->id }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    $('#thresholdTable').DataTable();

    $('.delete-threshold').click(function(){
        var thresholdId = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el threshold.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/rrhh/umbral/' + thresholdId,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response){
                        Swal.fire('Eliminado!', response.message, 'success').then(()=>{
                            location.reload();
                        });
                    },
                    error: function(){
                        Swal.fire('Error!', 'No se pudo eliminar el threshold.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@stop
