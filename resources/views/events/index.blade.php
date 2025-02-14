@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Lista de Eventos</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">Crear Nuevo Evento</a>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table id="events-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Consecutivo</th>
                    <th>Nombre del Evento</th>
                    <th>Fecha del Servicio</th>
                    <th>Responsable</th>
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
                    <td>{{ $event->responsible }}</td>
                    <td>
                        @php
                            $totalServices = 0;
                            $confirmedServices = 0;
                            $services = [
                                'metro_junior' => $event->metro_junior_required,
                                'aldimark' => $event->aldimark_required,
                                'maintenance' => $event->maintenance_required,
                                'general_services' => $event->general_services_required,
                                'systems' => $event->systems_required,
                                'purchases' => $event->purchases_required,
                                'communications' => $event->communications_required,
                            ];
                            
                            foreach($services as $service => $required) {
                                if($required) {
                                    $totalServices++;
                                    if($event->{$service . '_confirmed'}) {
                                        $confirmedServices++;
                                    }
                                }
                            }
                            
                            $percentage = $totalServices > 0 ? ($confirmedServices / $totalServices) * 100 : 0;
                        @endphp
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
                                {{ number_format($percentage) }}%
                            </div>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="viewDetails({{ $event->id }})">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
$(document).ready(function() {
    $('#events-table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });
});

function viewDetails(eventId) {
    // Implementar vista de detalles
    window.location.href = `/events/${eventId}`;
}
</script>
@stop
