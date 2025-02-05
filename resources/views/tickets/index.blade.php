@extends('adminlte::page')

@section('title', 'Listado de Tickets')

@section('content_header')
    <h1>Tickets</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">Nuevo Ticket</a>
    </div>
    <div class="card-body">
        <table id="ticketsTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Tipo de Requerimiento</th>
                    <th>Usuario</th>
                    <th>Técnico</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->titulo }}</td>
                    <td>
                        <span class="badge 
                            @if($ticket->estado == 'Abierto') badge-info 
                            @elseif($ticket->estado == 'En Proceso') badge-warning 
                            @else badge-success 
                            @endif">
                            {{ $ticket->estado }}
                        </span>
                    </td>
                    <td>
                        <span class="badge 
                            @if($ticket->prioridad == 'Baja') badge-success 
                            @elseif($ticket->prioridad == 'Media') badge-warning 
                            @else badge-danger 
                            @endif">
                            {{ $ticket->prioridad }}
                        </span>
                    </td>
                    <td>{{ $ticket->tipo_requerimiento }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>
                        {{ $ticket->tecnico ? $ticket->tecnico->name : 'Sin asignar' }}
                    </td>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @can('ticket.show')
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info">Ver</a>
                        @endcan
                        @can('ticket.edit')
                            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        @endcan
                        @can('ticket.delete')
                            <button data-id="{{ $ticket->id }}" class="btn btn-sm btn-danger delete-ticket">Eliminar</button>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#ticketsTable').DataTable();

        $('.delete-ticket').click(function() {
            var ticketId = $(this).data('id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/tickets/' + ticketId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Eliminado!', response.message, 'success');
                            location.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'No se pudo eliminar el ticket.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@stop