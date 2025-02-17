@extends('adminlte::page')

@section('title', 'Editar Umbral - Contabilidad')

@section('content_header')
    <h1>Editar Umbral - Contabilidad</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Editar Umbral de Contabilidad</h3>
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

            <form action="{{ route('umbral.contabilidad.update', $threshold->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kpi_name">Nombre del KPI</label>
                            <input type="text" name="kpi_name" id="kpi_name" class="form-control" 
                                   value="{{ old('kpi_name', $threshold->kpi_name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="value">Valor del Umbral (%)</label>
                            <input type="number" name="value" id="value" class="form-control" 
                                   min="0" max="100" value="{{ old('value', $threshold->value) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <a href="{{ route('umbral.contabilidad.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Umbral</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop