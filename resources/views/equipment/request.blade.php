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
                            <option value="administrativo">Administrativo</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo de Equipo</label>
                        <select name="equipment_id" class="form-control" required id="equipment-select" disabled>
                            <option value="">Primero seleccione una sección</option>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <i class="fas fa-info-circle"></i> 
                            Equipos disponibles: <span id="available-units" class="font-weight-bold">0</span>
                        </small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Salón</label>
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
        
        fetch(`/equipment/types/${selectedSection}`)
            .then(response => response.json())
            .then(data => {
                equipmentSelect.innerHTML = '<option value="">Seleccione un equipo</option>';
                
                // Si es administrativo, mostrar todos los equipos agrupados por sección
                if (selectedSection === 'administrativo') {
                    // Crear grupos de opciones por sección
                    const preescolarPrimaria = document.createElement('optgroup');
                    preescolarPrimaria.label = 'Preescolar y Primaria';
                    
                    const bachillerato = document.createElement('optgroup');
                    bachillerato.label = 'Bachillerato';
                    
                    let hasAvailableEquipment = false;
                    
                    data.forEach(equipment => {
                        if (equipment.available_units > 0) {
                            hasAvailableEquipment = true;
                            const option = new Option(
                                `${equipment.type} (${equipment.available_units} disponibles)`,
                                equipment.id
                            );
                            
                            if (equipment.section === 'preescolar_primaria') {
                                preescolarPrimaria.appendChild(option);
                            } else if (equipment.section === 'bachillerato') {
                                bachillerato.appendChild(option);
                            }
                        }
                    });
                    
                    if (!hasAvailableEquipment) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin Disponibilidad',
                            text: 'Actualmente no hay equipos disponibles para préstamo.',
                            confirmButtonText: 'Entendido'
                        });
                        equipmentSelect.disabled = true;
                        return;
                    }
                    
                    equipmentSelect.appendChild(preescolarPrimaria);
                    equipmentSelect.appendChild(bachillerato);
                } else {
                    // Para otras secciones, mantener el comportamiento actual
                    const filteredEquipment = data.filter(equipment => 
                        equipment.section === selectedSection && equipment.available_units > 0
                    );
                    
                    if (filteredEquipment.length === 0) {
                        const equipType = selectedSection === 'preescolar_primaria' ? 'iPads' : 'portátiles';
                        Swal.fire({
                            icon: 'info',
                            title: 'Sin Disponibilidad',
                            text: `Actualmente no hay ${equipType} disponibles para préstamo en esta sección.`,
                            confirmButtonText: 'Entendido'
                        });
                        equipmentSelect.disabled = true;
                        return;
                    }
                    
                    filteredEquipment.forEach(equipment => {
                        const option = new Option(
                            `${equipment.type} (${equipment.available_units} disponibles)`,
                            equipment.id
                        );
                        equipmentSelect.add(option);
                    });
                }
                
                equipmentSelect.disabled = false;
            });
        
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
        if (selectedOption && selectedOption.value) {
            const text = selectedOption.textContent;
            const matches = text.match(/\((\d+) disponibles\)/);
            const availableUnits = matches ? matches[1] : 0;
            
            availableUnitsSpan.innerHTML = `<strong>${availableUnits}</strong> equipos disponibles`;
            unitsInput.max = availableUnits;
            unitsInput.value = Math.min(unitsInput.value, availableUnits);
            
            if (availableUnits == 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin disponibilidad',
                    text: 'No hay equipos disponibles para este tipo'
                });
                unitsInput.disabled = true;
            } else {
                unitsInput.disabled = false;
            }
        } else {
            availableUnitsSpan.textContent = '0';
            unitsInput.value = '';
            unitsInput.disabled = true;
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
    
    // Validación de fechas
    document.getElementById('loan_date').addEventListener('change', function() {
        document.getElementById('return_date').min = this.value;
    });

    // SweetAlert para confirmación
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Confirmar solicitud?',
            text: "¿Desea proceder con la solicitud de préstamo?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
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
