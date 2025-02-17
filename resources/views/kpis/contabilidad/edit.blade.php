@extends('adminlte::page')

@section('title', 'Editar KPI - Contabilidad')

@section('content_header')
    <h1>Editar KPI - Contabilidad</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Editar KPI de Contabilidad</h3>
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

            <form action="{{ route('kpis.contabilidad.update', $kpi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="threshold_id">KPI a Medir</label>
                            <select name="threshold_id" id="threshold_id" class="form-control select2" required>
                                <option value="">Seleccione un KPI</option>
                                @foreach($thresholds as $threshold)
                                    <option value="{{ $threshold->id }}" {{ $kpi->threshold_id == $threshold->id ? 'selected' : '' }}>
                                        {{ $threshold->kpi_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Tipo de KPI</label>
                            <select name="type" id="type" class="form-control select2" required>
                                <option value="">Seleccione el tipo</option>
                                <option value="measurement" {{ $kpi->type == 'measurement' ? 'selected' : '' }}>Medición</option>
                                <option value="informative" {{ $kpi->type == 'informative' ? 'selected' : '' }}>Informativo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="methodology">Metodología</label>
                            <textarea name="methodology" id="methodology" class="form-control" rows="3" required>{{ $kpi->methodology }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="frequency">Frecuencia</label>
                            <select name="frequency" id="frequency" class="form-control select2" required>
                                <option value="">Seleccione la frecuencia</option>
                                <option value="Diario" {{ $kpi->frequency == 'Diario' ? 'selected' : '' }}>Diario</option>
                                <option value="Quincenal" {{ $kpi->frequency == 'Quincenal' ? 'selected' : '' }}>Quincenal</option>
                                <option value="Mensual" {{ $kpi->frequency == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                                <option value="Semestral" {{ $kpi->frequency == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="measurement_date">Fecha de Medición</label>
                            <input type="date" name="measurement_date" id="measurement_date" class="form-control" 
                                   value="{{ $kpi->measurement_date }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="percentage">Porcentaje Alcanzado</label>
                            <input type="number" name="percentage" id="percentage" class="form-control" 
                                   min="0" max="100" step="0.01" value="{{ $kpi->percentage }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <a href="{{ route('kpis.contabilidad.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar KPI</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4',
    });
});
</script>
@stop