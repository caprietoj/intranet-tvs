@extends('adminlte::page')

@section('title', 'KPI - Enfermería')

@section('content_header')
    <h1 class="text-primary">KPI - Enfermería</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title m-0">Formulario de Registro de KPI</h3>
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

        <form action="{{ route('kpis.enfermeria.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type" class="form-label">
                            Tipo de KPI <span class="text-danger">*</span>
                        </label>
                        <select name="type" id="type" class="form-control select2bs4 @error('type') is-invalid @enderror" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="measurement">Medición</option>
                            <option value="informative">Informativo</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="threshold_id" class="form-label">
                            Nombre del Indicador <span class="text-danger">*</span>
                        </label>
                        <select name="threshold_id" id="threshold_id" class="form-control select2bs4 @error('threshold_id') is-invalid @enderror" required>
                            <option value="">Seleccione un Indicador</option>
                            @foreach($thresholds as $threshold)
                                <option value="{{ $threshold->id }}">
                                    {{ $threshold->kpi_name }} (Umbral: {{ $threshold->value }}%)
                                </option>
                            @endforeach
                        </select>
                        @error('threshold_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="methodology" class="form-label">
                    Metodología de Medición <span class="text-danger">*</span>
                </label>
                <textarea name="methodology" id="methodology" class="form-control @error('methodology') is-invalid @enderror" rows="3" required>{{ old('methodology') }}</textarea>
                @error('methodology')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="frequency" class="form-label">
                            Frecuencia de Medición <span class="text-danger">*</span>
                        </label>
                        <select name="frequency" id="frequency" class="form-control select2bs4 @error('frequency') is-invalid @enderror" required>
                            <option value="">Seleccione una frecuencia</option>
                            <option value="Diario">Diario</option>
                            <option value="Quincenal">Quincenal</option>
                            <option value="Mensual">Mensual</option>
                            <option value="Semestral">Semestral</option>
                        </select>
                        @error('frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="measurement_date" class="form-label">
                            Fecha de Medición <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="measurement_date" id="measurement_date" 
                               class="form-control @error('measurement_date') is-invalid @enderror" 
                               value="{{ old('measurement_date') }}" required>
                        @error('measurement_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="percentage" class="form-label">
                            Porcentaje Alcanzado (%) <span class="text-danger">*</span>
                        </label>
                        <input type="number" step="0.01" min="0" max="100" name="percentage" 
                               id="percentage" class="form-control @error('percentage') is-invalid @enderror" 
                               value="{{ old('percentage') }}" required>
                        @error('percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kpis.enfermeria.index') }}" class="btn btn-secondary">
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
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    :root {
        --primary: #364E76;
        --accent: #ED3236;
        --input-height: 50px;
        --border-radius: 8px;
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .card-header {
        background-color: var(--primary);
        padding: 1.25rem 1.5rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .card-header .card-title {
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    /* Mejoras en los campos del formulario */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label, label {
        color: #2d3748;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    /* Estilizado base para todos los inputs */
    .form-control {
        height: var(--input-height) !important;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        border: 2px solid #e2e8f0;
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
    }

    /* Mejoras específicas para Select2 */
    .select2-container--bootstrap4 .select2-selection {
        height: var(--input-height) !important;
        border: 2px solid #e2e8f0;
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
    }

    .select2-container--bootstrap4 .select2-selection--single {
        padding-right: 2.5rem;
        background: #fff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat right 1rem center/16px 12px;
    }

    .select2-container--bootstrap4 .select2-selection__rendered {
        padding: 0 !important;
        line-height: 1.5 !important;
        color: #495057;
    }

    .select2-container--bootstrap4 .select2-selection__arrow {
        display: none;
    }

    .select2-container--bootstrap4 .select2-dropdown {
        border-color: var(--primary);
        border-radius: var(--border-radius);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .select2-container--bootstrap4 .select2-results__option {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary);
    }

    /* Estados de focus para inputs y Select2 */
    .form-control:focus,
    .select2-container--bootstrap4.select2-container--focus .select2-selection {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
        outline: none;
    }

    /* Estilos específicos para textarea */
    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* Estilos para inputs específicos */
    input[type="date"].form-control {
        padding: 0.6rem 1rem;
    }

    input[type="number"].form-control {
        padding-right: 1rem;
    }

    /* Estilos para mensajes de error */
    .invalid-feedback {
        color: var(--accent);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Botones mejorados */
    .btn {
        height: var(--input-height);
        padding: 0 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(54, 78, 118, 0.2);
    }

    /* Ajustes responsivos */
    @media (max-width: 768px) {
        .form-control,
        .select2-container--bootstrap4 .select2-selection {
            font-size: 16px;
        }

        .btn {
            width: 100%;
            justify-content: center;
            margin-top: 0.5rem;
        }
    }

    /* Estilos mejorados para el título y encabezado */
    .text-primary {
        color: var(--primary) !important;
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Asegurar que los contenedores Select2 tengan el ancho correcto
    $('.select2-container').css('width', '100%');
    
    // Inicialización mejorada de Select2
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Seleccione una opción',
        allowClear: true,
        dropdownAutoWidth: true,
        language: {
            noResults: function() {
                return "No se encontraron resultados";
            },
            searching: function() {
                return "Buscando...";
            }
        }
    });

    // Prevenir el zoom en móviles al enfocar inputs
    $('input, select, textarea').on('focus', function() {
        $(this).data('fontSize', $(this).css('font-size')).css('font-size', '16px');
    }).on('blur', function() {
        $(this).css('font-size', $(this).data('fontSize'));
    });

    // Validación del formulario
    $('form').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    // Validación en tiempo real para el porcentaje
    $('#percentage').on('input', function() {
        let value = parseFloat($(this).val());
        if (value < 0) $(this).val(0);
        if (value > 100) $(this).val(100);
    });
});
</script>
@stop