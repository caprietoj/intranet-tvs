{{-- resources/views/kpis/sistemas/create.blade.php --}}
@extends('adminlte::page')

@section('title', 'Nuevo KPI - Sistemas')

@section('content_header')
    <h1>Registrar KPI - Sistemas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('kpis.sistemas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="threshold_id">Nombre del KPI</label>
                <select name="threshold_id" id="threshold_id" class="form-control" required>
                    <option value="">Seleccione un KPI</option>
                    @foreach($thresholds as $threshold)
                        <option value="{{ $threshold->id }}">{{ $threshold->kpi_name }} (Umbral: {{ $threshold->value }}%)</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="methodology">Metodología de Medición</label>
                <input type="text" name="methodology" id="methodology" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="frequency">Frecuencia de Medición</label>
                <select name="frequency" id="frequency" class="form-control" required>
                    <option value="Diario">Diario</option>
                    <option value="Quincenal">Quincenal</option>
                    <option value="Mensual">Mensual</option>
                    <option value="Semestral">Semestral</option>
                </select>
            </div>
            <div class="form-group">
                <label for="measurement_date">Fecha de Medición</label>
                <input type="date" name="measurement_date" id="measurement_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="percentage">Porcentaje Alcanzado (%)</label>
                <input type="number" step="0.01" name="percentage" id="percentage" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar KPI</button>
        </form>
    </div>
</div>
@stop
