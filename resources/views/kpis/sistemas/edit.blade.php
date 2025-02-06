{{-- resources/views/kpis/sistemas/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar KPI - Sistemas')

@section('content_header')
    <h1>Editar KPI - Sistemas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('kpis.sistemas.update', $kpi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="threshold_id">Nombre del KPI</label>
                <select name="threshold_id" id="threshold_id" class="form-control" required>
                    <option value="">Seleccione un KPI</option>
                    @foreach($thresholds as $threshold)
                        <option value="{{ $threshold->id }}" {{ $kpi->threshold_id==$threshold->id ? 'selected' : '' }}>
                            {{ $threshold->kpi_name }} (Umbral: {{ $threshold->value }}%)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="methodology">Metodología de Medición</label>
                <input type="text" name="methodology" id="methodology" class="form-control" value="{{ $kpi->methodology }}" required>
            </div>
            <div class="form-group">
                <label for="frequency">Frecuencia de Medición</label>
                <select name="frequency" id="frequency" class="form-control" required>
                    <option value="Diario" {{ $kpi->frequency=='Diario'?'selected':'' }}>Diario</option>
                    <option value="Quincenal" {{ $kpi->frequency=='Quincenal'?'selected':'' }}>Quincenal</option>
                    <option value="Mensual" {{ $kpi->frequency=='Mensual'?'selected':'' }}>Mensual</option>
                    <option value="Semestral" {{ $kpi->frequency=='Semestral'?'selected':'' }}>Semestral</option>
                </select>
            </div>
            <div class="form-group">
                <label for="measurement_date">Fecha de Medición</label>
                <input type="date" name="measurement_date" id="measurement_date" class="form-control" value="{{ $kpi->measurement_date }}" required>
            </div>
            <div class="form-group">
                <label for="percentage">Porcentaje Alcanzado (%)</label>
                <input type="number" step="0.01" name="percentage" id="percentage" class="form-control" value="{{ $kpi->percentage }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar KPI</button>
        </form>
    </div>
</div>
@stop
