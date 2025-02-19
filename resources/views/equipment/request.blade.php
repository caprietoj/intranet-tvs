@extends('adminlte::page')

@section('title', 'Solicitar Equipo')

@section('content_header')
    <h1 class="text-primary">Solicitud de Préstamo de Equipo</h1>
@stop

@section('content')
<div class="card custom-card">
    <div class="card-body">
        <form id="loanRequestForm" action="{{ route('equipment.request.submit') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sección</label>
                        <select name="section" class="form-control" required id="section-select">
                            <option value="">Seleccione una sección</option>
                            <option value="bachillerato">Bachillerato</option>
                            <option value="preescolar_primaria">Preescolar y Primaria</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de Equipo</label>
                        <select name="equipment_id" class="form-control" required id="equipment-select">
                            <option value="">Seleccione el tipo de equipo</option>
                            @foreach($equipment as $item)
                                <option value="{{ $item->id }}" 
                                        data-section="{{ $item->section }}"
                                        data-type="{{ $item->type }}"
                                        data-available="{{ $item->available_units }}">
                                    {{ $item->type === 'laptop' ? 'Portátil' : 'iPad' }} 
                                    ({{ $item->available_units }} disponibles)
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Equipos disponibles: <span id="available-units">0</span></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Grado/Curso</label>
                        <input type="text" name="grade" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cantidad de Equipos</label>
                        <input type="number" name="units_requested" class="form-control" required min="1" id="units-input">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha del Préstamo</label>
                        <input type="date" name="loan_date" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hora de Inicio</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Hora de Finalización</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Solicitar Préstamo</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sectionSelect = document.getElementById('section-select');
    const equipmentSelect = document.getElementById('equipment-select');
    const unitsInput = document.getElementById('units-input');
    const availableUnitsSpan = document.getElementById('available-units');
    
    // Deshabilitar inicialmente el select de equipos
    equipmentSelect.disabled = true;
    
    // Filtrar equipos por sección
    sectionSelect.addEventListener('change', function() {
        const selectedSection = this.value;
        
        if (!selectedSection) {
            equipmentSelect.disabled = true;
            equipmentSelect.value = '';
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, seleccione primero una sección'
            });
            return;
        }
        
        equipmentSelect.disabled = false;
        const options = equipmentSelect.options;
        
        for(let i = 1; i < options.length; i++) {
            const option = options[i];
            const equipmentSection = option.dataset.section;
            
            if(selectedSection === 'preescolar_primaria' && option.dataset.type === 'laptop') {
                option.style.display = 'none';
            } else if(equipmentSection === selectedSection) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
        
        equipmentSelect.value = '';
        updateAvailableUnits();
    });

    // Cuando intenten seleccionar equipo sin sección
    equipmentSelect.addEventListener('click', function(e) {
        if (!sectionSelect.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, seleccione primero una sección'
            });
        }
    });

    // Actualizar unidades disponibles
    equipmentSelect.addEventListener('change', updateAvailableUnits);

    function updateAvailableUnits() {
        const selectedOption = equipmentSelect.selectedOptions[0];
        const availableUnits = selectedOption ? selectedOption.dataset.available : 0;
        availableUnitsSpan.textContent = availableUnits;
        unitsInput.max = availableUnits;
        
        if(selectedOption) {
            unitsInput.max = availableUnits;
            unitsInput.value = Math.min(unitsInput.value, availableUnits);
        }
    }

    // Validar fecha
    const loanDateInput = document.querySelector('input[name="loan_date"]');
    loanDateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        if(selectedDate <= new Date()) {
            Swal.fire({
                icon: 'error',
                title: 'Fecha inválida',
                text: 'Los préstamos deben solicitarse con al menos un día de anticipación.'
            });
            this.value = '';
        }
    });
});
</script>
@stop

@section('css')
<style>
    :root {
        --primary: #364E76;
        --accent: #ED3236;
    }

    .text-primary { color: var(--primary) !important; }

    .custom-card {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a3d5d;
        border-color: #2a3d5d;
    }

    .form-group label {
        color: #495057;
        font-weight: 500;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 4px;
        border: 1px solid #ddd;
        height: calc(2.25rem + 2px);
    }

    .select2-container--default .select2-selection--single:focus {
        border-color: var(--primary);
    }
</style>
@stop
