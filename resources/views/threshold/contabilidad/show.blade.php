@extends('adminlte::page')

@section('title', 'Ver Umbrales - Contabilidad')

@section('content_header')
    <h1>Umbrales Configurados - Contabilidad</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Umbrales</h3>
            <div class="card-tools">
                <a href="{{ route('umbral.contabilidad.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Umbral
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="thresholds-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del KPI</th>
                            <th>Valor del Umbral</th>
                            <th>Fecha de Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($thresholds as $threshold)
                            <tr>
                                <td>{{ $threshold->id }}</td>
                                <td>{{ $threshold->kpi_name }}</td>
                                <td>{{ $threshold->value }}%</td>
                                <td>{{ $threshold->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('umbral.contabilidad.edit', $threshold->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-threshold" 
                                            data-id="{{ $threshold->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay umbrales configurados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#thresholds-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });

    $('.delete-threshold').click(function() {
        const id = $(this).data('id');
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
                    url: `/contabilidad/umbral/${id}`,
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
                    error: function(xhr) {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el umbral',
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