@extends('adminlte::page')

@section('title', 'Detalles KPI - Contabilidad')

@section('content_header')
    <h1>Detalles KPI - Contabilidad</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Detalles del KPI de Contabilidad</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre del KPI:</label>
                        <p class="form-control">{{ $kpi->name }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo:</label>
                        <p class="form-control">{{ ucfirst($kpi->type) }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Metodología:</label>
                        <p class="form-control">{{ $kpi->methodology }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Frecuencia:</label>
                        <p class="form-control">{{ $kpi->frequency }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha de Medición:</label>
                        <p class="form-control">{{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Porcentaje Alcanzado:</label>
                        <p class="form-control">{{ $kpi->percentage }}%</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Estado:</label>
                        <p class="form-control">
                            <span class="badge {{ $kpi->status == ($kpi->type == 'measurement' ? 'Alcanzado' : 'Favorable') ? 'badge-success' : 'badge-danger' }}">
                                {{ $kpi->status }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Umbral:</label>
                        <p class="form-control">{{ $kpi->threshold->value }}%</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <a href="{{ route('kpis.contabilidad.index') }}" class="btn btn-secondary">Volver</a>
                    <a href="{{ route('kpis.contabilidad.edit', $kpi->id) }}" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop