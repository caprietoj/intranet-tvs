@extends('adminlte::page')

@section('title', 'Editar KPI - Enfermería')

@section('content_header')
    <h1>Editar KPI - Enfermería</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kpis.enfermeria.update', $kpi->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="type">Tipo de KPI</label>
                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="measurement" {{ $kpi->type == 'measurement' ? 'selected' : '' }}>Medición</option>
                    <option value="informative" {{ $kpi->type == 'informative' ? 'selected' : '' }}>Informativo</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="threshold_id">Nombre del KPI</label>
                <select name="threshold_id" id="threshold_id" class="form-control @error('threshold_id') is-invalid @enderror" required>
                    <option value="">Seleccione un KPI</option>
                    @foreach($thresholds as $threshold)
                        <option value="{{ $threshold->id }}" {{ $kpi->threshold_id == $threshold->id ? 'selected' : '' }}>
                            {{ $threshold->kpi_name }} (Umbral: {{ $threshold->value }}%)
                        </option>
                    @endforeach
                </select>
                @error('threshold_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="methodology">Metodología de Medición</label>
                <textarea name="methodology" id="methodology" class="form-control @error('methodology') is-invalid @enderror" rows="3" required>{{ old('methodology', $kpi->methodology) }}</textarea>
                @error('methodology')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="frequency">Frecuencia de Medición</label>
                <select name="frequency" id="frequency" class="form-control @error('frequency') is-invalid @enderror" required>
                    <option value="Diario" {{ $kpi->frequency == 'Diario' ? 'selected' : '' }}>Diario</option>
                    <option value="Quincenal" {{ $kpi->frequency == 'Quincenal' ? 'selected' : '' }}>Quincenal</option>
                    <option value="Mensual" {{ $kpi->frequency == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                    <option value="Semestral" {{ $kpi->frequency == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                </select>
                @error('frequency')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="measurement_date">Fecha de Medición</label>
                <input type="date" name="measurement_date" id="measurement_date" 
                       class="form-control @error('measurement_date') is-invalid @enderror" 
                       value="{{ old('measurement_date', $kpi->measurement_date) }}" required>
                @error('measurement_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="percentage">Porcentaje Alcanzado (%)</label>
                <input type="number" step="0.01" min="0" max="100" name="percentage" 
                       id="percentage" class="form-control @error('percentage') is-invalid @enderror" 
                       value="{{ old('percentage', $kpi->percentage) }}" required>
                @error('percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Actualizar KPI</button>
                <a href="{{ route('kpis.enfermeria.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .invalid-feedback {
        display: block;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inicializar Select2 para mejorar la experiencia de usuario en los selects
    $('#threshold_id').select2({
        placeholder: 'Seleccione un KPI',
        allowClear: true
    });

    $('#type').select2({
        placeholder: 'Seleccione el tipo',
        allowClear: true
    });

    $('#frequency').select2({
        placeholder: 'Seleccione la frecuencia',
        allowClear: true
    });

    // Validación del lado del cliente
    $('form').on('submit', function(e) {
        let percentage = parseFloat($('#percentage').val());
        if (percentage < 0 || percentage > 100) {
            e.preventDefault();
            alert('El porcentaje debe estar entre 0 y 100');
            return false;
        }
    });
});
</script>
@stop