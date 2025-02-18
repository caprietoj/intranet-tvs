{{-- resources/views/threshold/sistemas/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Threshold - Sistemas')

@section('content_header')
    <h1>Editar Configuración de Threshold - Sistemas</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('umbral.sistemas.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="kpi_name">Nombre del KPI</label>
                <input type="text" name="kpi_name" id="kpi_name" class="form-control" value="{{ $threshold->kpi_name }}" required>
            </div>
            <div class="form-group">
                <label for="value">Valor del Umbral (%)</label>
                <input type="number" step="0.01" name="value" id="value" class="form-control" value="{{ $threshold->value }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Umbral</button>
        </form>
    </div>
</div>
@stop
