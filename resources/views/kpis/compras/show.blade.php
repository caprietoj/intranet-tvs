{{-- resources/views/kpis/compras/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalle KPI Compras')

@section('content_header')
    <h1 class="text-primary">Detalle KPI - Compras</h1>
@stop

@section('content')
<div class="card custom-card">
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
        <a href="{{ route('kpis.compras.edit', $kpi->id) }}" class="btn btn-primary">Editar</a>
        <a href="{{ route('kpis.compras.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --primary: #364E76;
        --accent: #ED3236;
        --success: #28a745;
        --danger: #dc3545;
    }

    .text-primary {
        color: var(--primary) !important;
        font-weight: 600;
    }

    .custom-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.125);
        padding: 1.25rem;
    }

    .card-header h3 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
    }

    .card-body p {
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .badge {
        padding: 0.5em 1em;
        font-size: 0.85em;
        border-radius: 4px;
    }

    .badge-success { background-color: var(--success); }
    .badge-danger { background-color: var(--danger); }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a3d5d;
        transform: translateY(-2px);
    }

    .card-footer {
        background-color: transparent;
        border-top: 1px solid rgba(0,0,0,0.125);
        padding: 1rem 1.25rem;
    }
</style>
@stop
