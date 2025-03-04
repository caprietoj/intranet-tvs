@extends('adminlte::page')

@section('title', 'Detalles del Evento')

@section('content_header')
    <h1>Detalles del Evento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Información General</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>Consecutivo</th>
                        <td>{{ $event->consecutive }}</td>
                    </tr>
                    <tr>
                        <th>Nombre del Evento</th>
                        <td>{{ $event->event_name }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Solicitud</th>
                        <td>{{ $event->request_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Fecha del Servicio</th>
                        <td>{{ $event->service_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Hora del Evento</th>
                        <td>{{ $event->event_time }}</td>
                    </tr>
                    <tr>
                        <th>Lugar</th>
                        <td>{{ $event->location }}</td>
                    </tr>
                    <tr>
                        <th>Responsable</th>
                        <td>{{ $event->responsible }}</td>
                    </tr>
                    <tr>
                        <th>Parqueadero CAFAM</th>
                        <td>{{ $event->cafam_parking ? 'Sí' : 'No' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5>Estado de Servicios</h5>
                <table class="table table-bordered">
                    @if($event->metro_junior_required)
                    <tr>
                        <th>Metro Junior</th>
                        <td>
                            <span class="badge badge-{{ $event->metro_junior_confirmed ? 'success' : 'warning' }}">
                                {{ $event->metro_junior_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif

                    @if($event->aldimark_required)
                    <tr>
                        <th>Aldimark</th>
                        <td>
                            <span class="badge badge-{{ $event->aldimark_confirmed ? 'success' : 'warning' }}">
                                {{ $event->aldimark_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif

                    @if($event->maintenance_required)
                    <tr>
                        <th>Mantenimiento</th>
                        <td>
                            <span class="badge badge-{{ $event->maintenance_confirmed ? 'success' : 'warning' }}">
                                {{ $event->maintenance_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif

                    @if($event->general_services_required)
                    <tr>
                        <th>Servicios Generales</th>
                        <td>
                            <span class="badge badge-{{ $event->general_services_confirmed ? 'success' : 'warning' }}">
                                {{ $event->general_services_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif

                    @if($event->systems_required)
                    <tr>
                        <th>Sistemas</th>
                        <td>
                            <span class="badge badge-{{ $event->systems_confirmed ? 'success' : 'warning' }}">
                                {{ $event->systems_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif

                    @if($event->purchases_required)
                    <tr>
                        <th>Compras</th>
                        <td>
                            <span class="badge badge-{{ $event->purchases_confirmed ? 'success' : 'warning' }}">
                                {{ $event->purchases_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif

                    @if($event->communications_required)
                    <tr>
                        <th>Comunicaciones</th>
                        <td>
                            <span class="badge badge-{{ $event->communications_confirmed ? 'success' : 'warning' }}">
                                {{ $event->communications_confirmed ? 'Confirmado' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --primary: #1a4884;
        --success: #28a745;
        --warning: #ffc107;
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
        box-shadow: 0 4px 8px rgba(0,0,0,.12);
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        width: 200px;
        background: linear-gradient(to right, rgba(26, 72, 132, 0.05), rgba(26, 72, 132, 0.1));
        font-weight: 600;
        color: var(--primary);
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
    }

    .badge-success {
        background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
    }

    .badge-warning {
        background: linear-gradient(135deg, var(--warning) 0%, #ffdb4d 100%);
        color: #000;
    }

    .alert {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #868e96 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.35);
    }
</style>
@stop
