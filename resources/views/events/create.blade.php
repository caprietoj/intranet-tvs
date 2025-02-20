@extends('adminlte::page')

@section('title', 'Crear Evento')

@section('content_header')
    <h1>Crear Nuevo Evento</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('events.store') }}" method="POST" id="eventForm">
            @csrf
            <!-- Campos básicos sin el consecutivo -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha de solicitud</label>
                        <input type="date" name="request_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <!-- Basic Event Information -->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nombre del evento</label>
                        <input type="text" name="event_name" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- More basic fields... -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sección</label>
                        <input type="text" name="section" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Responsable</label>
                        <input type="text" name="responsible" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha del servicio</label>
                        <input type="date" name="service_date" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Hora inicio</label>
                        <input type="time" name="event_time" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Hora final</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lugar</label>
                        <select name="location" class="form-control" required>
                            <option value="">Seleccione un lugar</option>
                            <option value="Plaza Colibri">Plaza Colibrí</option>
                            <option value="Cancha football">Cancha Fútbol</option>
                            <option value="Cancha Baloncesto">Cancha Baloncesto</option>
                            <option value="Tienda">Tienda</option>
                            <option value="Biblioteca Primer Piso">Biblioteca Primer Piso</option>
                            <option value="Biblioteca Tercer Piso">Biblioteca Tercer Piso</option>
                            <option value="Auditorio">Auditorio</option>
                            <option value="Teatro">Teatro</option>
                            <option value="Retiro San Juan">Retiro San Juan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Solicitud de parqueadero CAFAM</label>
                <select name="cafam_parking" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <!-- Service Sections - Reordenados -->
            <div class="card mt-4">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Servicios Requeridos</h3>
                </div>
                <div class="card-body">
                    <!-- Transporte -->
                    <div class="service-group mb-4">
                        <h4 class="text-primary">Transporte</h4>
                        <div class="service-section mb-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="metro_junior_required" name="metro_junior_required" value="1">
                                <label class="custom-control-label" for="metro_junior_required">Metro Junior</label>
                            </div>
                            <div id="metro_junior_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Ruta</label>
                                    <input type="text" name="route" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Cantidad de pasajeros</label>
                                    <input type="number" name="passengers" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora de salida</label>
                                    <input type="time" name="departure_time" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora de regreso</label>
                                    <input type="time" name="return_time" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea name="metro_junior_observations" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios de Montaje -->
                    <div class="service-group mb-4">
                        <h4 class="text-primary">Servicios de Montaje</h4>
                        <!-- Servicios Generales -->
                        <div class="service-section mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="general_services_required" name="general_services_required" value="1">
                                <label class="custom-control-label" for="general_services_required">Servicios Generales</label>
                            </div>
                            <div id="general_services_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Requerimiento</label>
                                    <input type="text" name="general_services_requirement" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Fecha de montaje</label>
                                    <input type="date" name="general_services_setup_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora de montaje</label>
                                    <input type="time" name="general_services_setup_time" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Mantenimiento -->
                        <div class="service-section mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="maintenance_required" name="maintenance_required" value="1">
                                <label class="custom-control-label" for="maintenance_required">Mantenimiento</label>
                            </div>
                            <div id="maintenance_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Requerimiento</label>
                                    <input type="text" name="maintenance_requirement" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Fecha de montaje</label>
                                    <input type="date" name="maintenance_setup_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora de montaje</label>
                                    <input type="time" name="maintenance_setup_time" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Sistemas -->
                        <div class="service-section mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="systems_required" name="systems_required" value="1">
                                <label class="custom-control-label" for="systems_required">Sistemas</label>
                            </div>
                            <div id="systems_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Requerimiento</label>
                                    <input type="text" name="systems_requirement" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Fecha de montaje</label>
                                    <input type="date" name="systems_setup_date" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora de montaje</label>
                                    <input type="time" name="systems_setup_time" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea name="systems_observations" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios de Alimentación -->
                    <div class="service-group mb-4">
                        <h4 class="text-primary">Alimentación</h4>
                        <div class="service-section">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="aldimark_required" name="aldimark_required" value="1">
                                <label class="custom-control-label" for="aldimark_required">Aldimark</label>
                            </div>
                            <div id="aldimark_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Requerimiento</label>
                                    <input type="text" name="aldimark_requirement" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Hora</label>
                                    <input type="time" name="aldimark_time" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Detalles</label>
                                    <textarea name="aldimark_details" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Otros Servicios -->
                    <div class="service-group mb-4">
                        <h4 class="text-primary">Otros Servicios</h4>
                        <!-- Compras -->
                        <div class="service-section mb-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="purchases_required" name="purchases_required" value="1">
                                <label class="custom-control-label" for="purchases_required">Compras</label>
                            </div>
                            <div id="purchases_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Requerimiento</label>
                                    <input type="text" name="purchases_requirement" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea name="purchases_observations" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Comunicaciones -->
                        <div class="service-section">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="communications_required" name="communications_required" value="1">
                                <label class="custom-control-label" for="communications_required">Comunicaciones</label>
                            </div>
                            <div id="communications_fields" class="service-fields" style="display: none;">
                                <div class="form-group">
                                    <label>Cubrimiento</label>
                                    <input type="text" name="communications_coverage" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea name="communications_observations" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Crear Evento</button>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --primary: #1a4884;
        --secondary: #6c757d;
        --border-radius: 8px;
        --box-shadow: 0 2px 4px rgba(0,0,0,.08);
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        border-bottom: none;
    }

    .service-group {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .service-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .service-fields {
        margin-left: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: var(--border-radius);
        margin-top: 1rem;
        border: 1px solid #e9ecef;
    }

    .form-group label {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 6px;
        border: 2px solid #e9ecef;
        padding: 0.5rem 1rem;
        height: calc(2.25rem + 8px);
        font-size: 1rem;
        line-height: 1.5;
        transition: all 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(26, 72, 132, 0.25);
    }

    textarea.form-control {
        height: auto;
        min-height: 100px;
    }

    select.form-control {
        padding-right: 2rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Cpath fill='%23666' d='M0 2l4 4 4-4z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 8px;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 72, 132, 0.35);
    }

    .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--primary);
        border-color: var(--primary);
    }
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simplificado y más directo
    function setupServiceToggle(serviceId) {
        const checkbox = document.getElementById(serviceId);
        const fieldsDiv = document.getElementById(serviceId.replace('_required', '_fields'));
        
        if (!checkbox || !fieldsDiv) {
            console.error(`Elementos no encontrados para ${serviceId}`);
            return;
        }

        checkbox.addEventListener('change', function() {
            fieldsDiv.style.display = this.checked ? 'block' : 'none';
            
            // Toggle required attributes
            const inputs = fieldsDiv.querySelectorAll('input[type="text"], input[type="number"], input[type="time"], input[type="date"], textarea');
            inputs.forEach(input => {
                if (this.checked) {
                    input.setAttribute('required', '');
                } else {
                    input.removeAttribute('required');
                    input.value = ''; // Clear values when unchecked
                }
            });
        });

        // Initial state
        fieldsDiv.style.display = checkbox.checked ? 'block' : 'none';
    }

    // Initialize all service toggles
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
