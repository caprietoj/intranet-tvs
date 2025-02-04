{{-- resources/views/threshold/rrhh/create.blade.php --}}
@extends('adminlte::page')

@section('title', 'Crear Threshold - Recursos Humanos')

@section('content_header')
    <h1>Crear Configuración de Threshold - Recursos Humanos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('umbral.rrhh.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kpi_name">Nombre del KPI</label>
                <input type="text" name="kpi_name" id="kpi_name" class="form-control" placeholder="Ingrese el nombre del KPI" required>
            </div>
            <div class="form-group">
                <label for="value">Valor del Threshold (%)</label>
                <input type="number" step="0.01" name="value" id="value" class="form-control" placeholder="Ej. 80" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Threshold</button>
        </form>
    </div>
</div>
@stop
