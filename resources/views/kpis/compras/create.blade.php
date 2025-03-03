@extends('adminlte::page')

@section('title', 'Nuevo KPI - Compras')

@section('content_header')
    <h1>Registrar KPI - Compras</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Formulario de Registro de KPI</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Nuevo bloque informativo -->
        <div class="alert alert-info alert-dismissible fade show">
            <h5><i class="icon fas fa-info"></i> Cálculo del Porcentaje de Satisfacción</h5>
            <p>El sistema calcula el porcentaje de satisfacción basándose en la siguiente escala:</p>
            <ul>
                <li><strong>5 puntos (100%):</strong> MUY SATISFECHO / EXCELENTE / SÍ</li>
                <li><strong>4 puntos (80%):</strong> SATISFECHO / BUENO</li>
                <li><strong>3 puntos (60%):</strong> NEUTRAL / REGULAR / A VECES</li>
                <li><strong>2 puntos (40%):</strong> POCO SATISFECHO / MALO</li>
                <li><strong>1 punto (20%):</strong> INSATISFECHO / DEFICIENTE / NO</li>
            </ul>
            <p>El proceso de cálculo es el siguiente:</p>
            <ol>
                <li>Se clasifica cada respuesta según la escala anterior</li>
                <li>Se calcula el promedio por área (estudiantes, docentes, administrativos)</li>
                <li>Se obtiene el porcentaje final como promedio general de todas las áreas</li>
            </ol>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <form action="{{ route('kpis.compras.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type" class="form-label">
                            Tipo de KPI <span class="text-danger">*</span>
                        </label>
                        <select name="type" id="type" class="form-control select2bs4" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="measurement">Medición</option>
                            <option value="informative">Informativo</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="threshold_id" class="form-label">
                            Nombre del Indicador <span class="text-danger">*</span>
                        </label>
                        <select name="threshold_id" id="threshold_id" class="form-control @error('threshold_id') is-invalid @enderror" required>
                            <option value="">Seleccione un Indicador</option>
                            @foreach($thresholds as $threshold)
                                <option value="{{ $threshold->id }}" {{ old('threshold_id') == $threshold->id ? 'selected' : '' }}>
                                    {{ $threshold->kpi_name }} ({{ $threshold->value }}%)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="methodology" class="form-label">
                    Metodología de Medición <span class="text-danger">*</span>
                </label>
                <textarea name="methodology" id="methodology" class="form-control" rows="3" required>{{ old('methodology') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="frequency" class="form-label">
                            Frecuencia de Medición <span class="text-danger">*</span>
                        </label>
                        <select name="frequency" id="frequency" class="form-control select2bs4" required>
                            <option value="">Seleccione una frecuencia</option>
                            <option value="Diario">Diario</option>
                            <option value="Quincenal">Quincenal</option>
                            <option value="Mensual">Mensual</option>
                            <option value="Semestral">Semestral</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="measurement_date" class="form-label">
                            Fecha de Medición <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="measurement_date" id="measurement_date" 
                               class="form-control" value="{{ old('measurement_date') }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="percentage" class="form-label">
                            Porcentaje Alcanzado (%) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" max="100" name="percentage" 
                                   id="percentage" class="form-control" value="{{ old('percentage') }}" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadExcelModal">
                                    <i class="fas fa-file-excel"></i> Calcular desde Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kpis.compras.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Volver
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Registrar KPI
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="uploadExcelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Procesar datos de encuesta</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Datos de la encuesta</label>
                    <textarea class="form-control" id="survey_data" rows="10" 
                        placeholder="Pegue aquí los datos de la encuesta..."></textarea>
                    <small class="form-text text-muted">
                        Los datos deben contener las siguientes columnas en este orden:<br>
                        <ul>
                            <li>Dependencia</li>
                            <li>1. ¿Cómo califica su experiencia con el servicio de Almacén?</li>
                            <li>2. ¿Cómo califica los tiempos de atención?</li>
                            <li>3. ¿Ha logrado satisfacer su necesidad?</li>
                            <li>4. ¿Cómo consideran la disponibilidad de los elementos?</li>
                            <li>5. Califica tu satisfacción respecto al personal para resolver tu problema.</li>
                        </ul>
                        Copie y pegue directamente desde Excel.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="processData">Procesar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
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
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%) !important;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        padding: 1.5rem;
    }

    .card-header .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .form-control {
        border-radius: 6px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        height: auto;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(26, 72, 132, 0.25);
    }

    .select2-container--bootstrap4 .select2-selection {
        border: 2px solid #e9ecef;
        border-radius: 6px;
        min-height: 45px;
        padding: 0.5rem;
    }

    .select2-container--bootstrap4.select2-container--focus .select2-selection {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(26, 72, 132, 0.25);
    }

    .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #2a5298 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(26, 72, 132, 0.25);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2a5298 0%, var(--primary) 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 72, 132, 0.35);
    }

    .alert {
        border-radius: var(--border-radius);
        border: none;
        box-shadow: var(--box-shadow);
    }

    .text-danger {
        color: var(--danger) !important;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }

        .btn {
            width: 100%;
            margin: 0.5rem 0;
        }
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Seleccione una opción'
    });

    $('#percentage').on('input', function() {
        let value = parseFloat($(this).val());
        if (value < 0) $(this).val(0);
        if (value > 100) $(this).val(100);
    });
});

document.getElementById('processData').addEventListener('click', function() {
    const surveyData = document.getElementById('survey_data').value;
    const thresholdId = document.getElementById('threshold_id').value;
    
    if (!thresholdId) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor seleccione un indicador'
        });
        return;
    }

    if (!surveyData.trim()) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor ingrese los datos de la encuesta'
        });
        return;
    }

    // Mostrar loading
    Swal.fire({
        title: 'Procesando datos',
        text: 'Por favor espere...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('{{ route("satisfaction.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            survey_data: surveyData,
            threshold_id: parseInt(thresholdId)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('percentage').value = data.percentage.toFixed(2);
            $('#uploadExcelModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Datos procesados correctamente'
            });
        } else {
            throw new Error(data.message || 'Error al procesar los datos');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Error al procesar los datos'
        });
        console.error('Error:', error);
    });
});
</script>
@stop