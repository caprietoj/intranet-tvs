@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Eventos</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">Crear Evento</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="events-table">
                <thead>
                    <tr>
                        <th>Consecutivo</th>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Lugar</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td>{{ $event->consecutive }}</td>
                        <td>{{ $event->event_name }}</td>
                        <td>{{ $event->service_date->format('d/m/Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>
                            @php
                                $confirmedCount = 0;
                                $totalRequired = 0;
                                $services = ['metro_junior', 'aldimark', 'maintenance', 'general_services', 'systems', 'purchases', 'communications'];
                                foreach($services as $service) {
                                    $requiredField = $service . '_required';
                                    $confirmedField = $service . '_confirmed';
                                    if($event->$requiredField) {
                                        $totalRequired++;
                                        if($event->$confirmedField) $confirmedCount++;
                                    }
                                }
                                $percentage = $totalRequired > 0 ? ($confirmedCount / $totalRequired) * 100 : 0;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%">
                                    {{ number_format($percentage) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-event">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --primary: #1a4884;
        --secondary: #6c757d;
        --success: #28a745;
        --danger: #dc3545;
        --border-radius: 8px;
        --box-shadow: 0 2px 4px rgba(0,0,0,.08);
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .progress {
        height: 20px;
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .progress-bar {
        transition: width 0.6s ease;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
    }

    .table thead th {
        background: linear-gradient(to right, rgba(26, 72, 132, 0.05), rgba(26, 72, 132, 0.1));
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
    }

    .btn i {
        margin-right: 0.3rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(26, 72, 132, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 72, 132, 0.35);
    }

    @media (max-width: 768px) {
        .btn {
            margin: 0.2rem 0;
            display: block;
            width: 100%;
        }
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert para mensajes de sesión
    @if(session('swal'))
        Swal.fire({
            icon: '{{ session("swal.icon") }}',
            title: '{{ session("swal.title") }}',
            text: '{{ session("swal.text") }}',
            showConfirmButton: true,
            timer: 3000
        });
    @endif

    // SweetAlert para confirmar eliminación
    $(document).on('click', '.delete-event', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        
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
                form.submit();
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('#events-table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "order": [[2, "desc"]]
    });
});
</script>
@stop
