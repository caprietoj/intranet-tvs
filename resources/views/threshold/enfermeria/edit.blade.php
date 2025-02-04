@extends('adminlte::page')

@section('title', 'Editar Threshold - Enfermería')

@section('content_header')
    <h1>Editar Configuración de Threshold - Enfermería</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('umbral.enfermeria.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="kpi_name">Nombre del KPI</label>
                <input type="text" name="kpi_name" id="kpi_name" class="form-control" value="{{ $threshold->kpi_name }}" required>
            </div>
            <div class="form-group">
                <label for="value">Valor del Threshold (%)</label>
                <input type="number" step="0.01" name="value" id="value" class="form-control" value="{{ $threshold->value }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Threshold</button>
        </form>
    </div>
</div>
@stop
