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
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">
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
.progress { height: 20px; }
</style>
@stop

@section('js')
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
