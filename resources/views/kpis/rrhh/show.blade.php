{{-- resources/views/kpis/rrhh/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalle del KPI - Recursos Humanos')

@section('content_header')
    <h1>Detalle del KPI - Recursos Humanos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3>{{ $kpi->name }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Metodología de Medición:</strong> {{ $kpi->methodology }}</p>
        <p><strong>Frecuencia de Medición:</strong> {{ $kpi->frequency }}</p>
        <p><strong>Fecha de Medición:</strong> {{ \Carbon\Carbon::parse($kpi->measurement_date)->format('d/m/Y') }}</p>
        <p><strong>Porcentaje Alcanzado:</strong> {{ $kpi->percentage }}%</p>
        <p>
            <strong>Estado:</strong>
            <span class="badge {{ $kpi->status=='Alcanzado' ? 'badge-success' : 'badge-danger' }}">
                {{ $kpi->status }}
            </span>
        </p>
    </div>
    <div class="card-footer">
        <a href="{{ route('kpis.rrhh.edit', $kpi->id) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('kpis.rrhh.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@stop