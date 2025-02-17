@extends('adminlte::page')

@section('title', 'Nuevo KPI - Sistemas')

@section('content_header')
    <h1>Registrar KPI - Sistemas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Formulario de Registro de KPI</h3>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kpis.sistemas.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="type">Tipo de KPI <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-control select2bs4" required>
                            <option value="measurement">Medición</option>
                            <option value="informative">Informativo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="threshold_id">Nombre del KPI <span class="text-danger">*</span></label>
                        <select name="threshold_id" id="threshold_id" class="form-control select2bs4" required>
                            <option value="">Seleccione un KPI</option>
                            @foreach($thresholds as $threshold)
                                <option value="{{ $threshold->id }}">
                                    {{ $threshold->kpi_name }} (Umbral: {{ $threshold->value }}%)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="methodology">Metodología de Medición <span class="text-danger">*</span></label>
                <textarea name="methodology" id="methodology" class="form-control" rows="3" required>{{ old('methodology') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="frequency">Frecuencia de Medición <span class="text-danger">*</span></label>
                        <select name="frequency" id="frequency" class="form-control select2bs4" required>
                            <option value="Diario">Diario</option>
                            <option value="Quincenal">Quincenal</option>
                            <option value="Mensual">Mensual</option>
                            <option value="Semestral">Semestral</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="measurement_date">Fecha de Medición <span class="text-danger">*</span></label>
                        <input type="date" name="measurement_date" id="measurement_date" 
                               class="form-control" required value="{{ old('measurement_date') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="percentage">Porcentaje Alcanzado (%) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" max="100" 
                               name="percentage" id="percentage" class="form-control" 
                               required value="{{ old('percentage') }}">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('kpis.sistemas.index') }}" class="btn btn-secondary">
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
    .select2-container--bootstrap4 .select2-selection {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .select2-container--bootstrap4 .select2-selection--single {
        height: 38px !important;
        padding: 0.375rem 0.75rem;
        line-height: 1.5;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    $('#percentage').on('input', function() {
        let value = parseFloat($(this).val());
        if (value < 0) $(this).val(0);
        if (value > 100) $(this).val(100);
    });
});
</script>
@stop