@extends('adminlte::page')

@section('title', 'Editar Evento')

@section('content_header')
    <h1>Editar Evento #{{ $event->consecutive }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('events.update', $event) }}" method="POST" id="eventForm">
            @csrf
            @method('PUT')
            
            <!-- Campos básicos -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha de solicitud</label>
                        <input type="date" name="request_date" class="form-control" required value="{{ $event->request_date->format('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <!-- Información del Evento -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nombre del evento</label>
                        <input type="text" name="event_name" class="form-control" required value="{{ $event->event_name }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sección</label>
                        <input type="text" name="section" class="form-control" required value="{{ $event->section }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Responsable</label>
                        <input type="text" name="responsible" class="form-control" required value="{{ $event->responsible }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha del servicio</label>
                        <input type="date" name="service_date" class="form-control" required value="{{ $event->service_date->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Hora inicio</label>
                        <input type="time" name="event_time" class="form-control" required value="{{ date('H:i', strtotime($event->event_time)) }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Hora final</label>
                        <input type="time" name="end_time" class="form-control" required value="{{ date('H:i', strtotime($event->end_time)) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lugar</label>
                        <select name="location" class="form-control" required>
                            @php
                                $locations = [
                                    'Plaza Colibri' => 'Plaza Colibrí',
                                    'Cancha football' => 'Cancha Fútbol',
                                    'Cancha Baloncesto' => 'Cancha Baloncesto',
                                    'Tienda' => 'Tienda',
                                    'Biblioteca Primer Piso' => 'Biblioteca Primer Piso',
                                    'Biblioteca Tercer Piso' => 'Biblioteca Tercer Piso',
                                    'Auditorio' => 'Auditorio',
                                    'Teatro' => 'Teatro',
                                    'Retiro San Juan' => 'Retiro San Juan'
                                ];
                            @endphp
                            @foreach($locations as $value => $label)
                                <option value="{{ $value }}" {{ $event->location == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Solicitud de parqueadero CAFAM</label>
                <select name="cafam_parking" class="form-control">
                    <option value="0" {{ !$event->cafam_parking ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $event->cafam_parking ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <!-- Servicios -->
            <div class="card mt-4">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Servicios Requeridos</h3>
                </div>
                <div class="card-body">
                    <!-- Metro Junior -->
                    <div class="service-section mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="metro_junior_required" 
                                   name="metro_junior_required" value="1" {{ $event->metro_junior_required ? 'checked' : '' }}>
                            <label class="custom-control-label" for="metro_junior_required">Metro Junior</label>
                        </div>
                        <div id="metro_junior_fields" class="service-fields" style="display: none;">
                            <div class="form-group">
                                <label>Ruta</label>
                                <input type="text" name="route" class="form-control" value="{{ $event->route }}">
                            </div>
                            <div class="form-group">
                                <label>Cantidad de pasajeros</label>
                                <input type="number" name="passengers" class="form-control" value="{{ $event->passengers }}">
                            </div>
                            <div class="form-group">
                                <label>Hora de salida</label>
                                <input type="time" name="departure_time" class="form-control" 
                                       value="{{ $event->departure_time ? date('H:i', strtotime($event->departure_time)) : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Hora de regreso</label>
                                <input type="time" name="return_time" class="form-control"
                                       value="{{ $event->return_time ? date('H:i', strtotime($event->return_time)) : '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Otros servicios (similar structure) -->
                    @php
                        $services = [
                            'general_services' => [
                                'label' => 'Servicios Generales',
                                'fields' => [
                                    'requirement' => 'Requerimiento',
                                    'setup_date' => 'Fecha de montaje',
                                    'setup_time' => 'Hora de montaje'
                                ]
                            ],
                            'maintenance' => [
                                'label' => 'Mantenimiento',
                                'fields' => [
                                    'requirement' => 'Requerimiento',
                                    'setup_date' => 'Fecha de montaje',
                                    'setup_time' => 'Hora de montaje'
                                ]
                            ],
                            'systems' => [
                                'label' => 'Sistemas',
                                'fields' => [
                                    'requirement' => 'Requerimiento',
                                    'setup_date' => 'Fecha de montaje',
                                    'setup_time' => 'Hora de montaje',
                                    'observations' => 'Observaciones'
                                ]
                            ],
                            'purchases' => [
                                'label' => 'Compras',
                                'fields' => [
                                    'requirement' => 'Requerimiento',
                                    'observations' => 'Observaciones'
                                ]
                            ],
                            'communications' => [
                                'label' => 'Comunicaciones',
                                'fields' => [
                                    'coverage' => 'Cubrimiento',
                                    'observations' => 'Observaciones'
                                ]
                            ],
                            'aldimark' => [
                                'label' => 'Aldimark',
                                'fields' => [
                                    'requirement' => 'Requerimiento',
                                    'time' => 'Hora',
                                    'details' => 'Detalles'
                                ]
                            ]
                        ];
                    @endphp

                    @foreach($services as $service => $config)
                        <div class="service-section mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" 
                                       id="{{ $service }}_required" 
                                       name="{{ $service }}_required" 
                                       value="1" 
                                       {{ $event->{$service.'_required'} ? 'checked' : '' }}>
                                <label class="custom-control-label" for="{{ $service }}_required">{{ $config['label'] }}</label>
                            </div>
                            <div id="{{ $service }}_fields" class="service-fields" style="display: none;">
                                @foreach($config['fields'] as $field => $label)
                                    <div class="form-group">
                                        <label>{{ $label }}</label>
                                        @if(strpos($field, 'date') !== false)
                                            <input type="date" 
                                                   name="{{ $service }}_{{ $field }}" 
                                                   class="form-control"
                                                   value="{{ $event->{$service.'_'.$field} ? $event->{$service.'_'.$field}->format('Y-m-d') : '' }}">
                                        @elseif(strpos($field, 'time') !== false)
                                            <input type="time" 
                                                   name="{{ $service }}_{{ $field }}" 
                                                   class="form-control"
                                                   value="{{ $event->{$service.'_'.$field} ? date('H:i', strtotime($event->{$service.'_'.$field})) : '' }}">
                                        @elseif(in_array($field, ['observations', 'details']))
                                            <textarea name="{{ $service }}_{{ $field }}" 
                                                      class="form-control">{{ $event->{$service.'_'.$field} }}</textarea>
                                        @else
                                            <input type="text" 
                                                   name="{{ $service }}_{{ $field }}" 
                                                   class="form-control"
                                                   value="{{ $event->{$service.'_'.$field} }}">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
.service-group {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 1rem;
}
.service-group:last-child {
    border-bottom: none;
}
.service-fields {
    margin-left: 1.5rem;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.25rem;
    margin-top: 0.5rem;
}
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function setupServiceToggle(serviceId) {
        const checkbox = document.getElementById(serviceId);
        const fieldsDiv = document.getElementById(serviceId.replace('_required', '_fields'));
        
        if (!checkbox || !fieldsDiv) return;

        function toggleFields() {
            fieldsDiv.style.display = checkbox.checked ? 'block' : 'none';
            const inputs = fieldsDiv.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (checkbox.checked) {
                    input.setAttribute('required', '');
                } else {
                    input.removeAttribute('required');
                }
            });
        }

        checkbox.addEventListener('change', toggleFields);
        toggleFields(); // Initial state
    }

    const services = [
        'metro_junior_required',
        'general_services_required',
        'maintenance_required',
        'systems_required',
        'aldimark_required',
        'purchases_required',
        'communications_required'
    ];

    services.forEach(setupServiceToggle);
});
</script>
@stop
