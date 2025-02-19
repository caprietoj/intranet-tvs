@extends('adminlte::page')

@section('title', 'Gestión de Equipos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary">Gestión de Equipos</h1>
        <div>
            @can('equipment.manage')
                <form action="{{ route('equipment.reset') }}" method="POST" class="d-inline" id="resetForm">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-sync-alt"></i> Reiniciar Inventario
                    </button>
                </form>
            @endcan
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Cards de Bachillerato -->
    <div class="card card-outline card-primary mb-4 elevation-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-school mr-2"></i>
                Bachillerato
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Portátiles -->
                <div class="col-md-6">
                    <div class="info-box bg-gradient-primary">
                        <span class="info-box-icon">
                            <i class="fas fa-laptop"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold">Portátiles</span>
                            <div class="progress-description">
                                Disponibles: {{ $equipment->where('section', 'bachillerato')->where('type', 'laptop')->sum('available_units') }}
                                de
                                {{ $equipment->where('section', 'bachillerato')->where('type', 'laptop')->sum('total_units') }}
                            </div>
                            <div class="progress">
                                @php
                                    $laptops = $equipment->where('section', 'bachillerato')->where('type', 'laptop')->first();
                                    $percentage = $laptops ? ($laptops->available_units / $laptops->total_units) * 100 : 0;
                                @endphp
                                <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- iPads -->
                <div class="col-md-6">
                    <div class="info-box bg-gradient-info">
                        <span class="info-box-icon">
                            <i class="fas fa-tablet-alt"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold">iPads</span>
                            <div class="progress-description">
                                Disponibles: {{ $equipment->where('section', 'bachillerato')->where('type', 'ipad')->sum('available_units') }}
                                de
                                {{ $equipment->where('section', 'bachillerato')->where('type', 'ipad')->sum('total_units') }}
                            </div>
                            <div class="progress">
                                @php
                                    $ipads = $equipment->where('section', 'bachillerato')->where('type', 'ipad')->first();
                                    $percentage = $ipads ? ($ipads->available_units / $ipads->total_units) * 100 : 0;
                                @endphp
                                <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Preescolar y Primaria -->
    <div class="card card-outline card-success elevation-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-child mr-2"></i>
                Preescolar y Primaria
            </h3>
        </div>
        <div class="card-body">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon">
                    <i class="fas fa-tablet-alt"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text text-bold">iPads</span>
                    <div class="progress-description">
                        Disponibles: {{ $equipment->where('section', 'preescolar_primaria')->where('type', 'ipad')->sum('available_units') }}
                        de
                        {{ $equipment->where('section', 'preescolar_primaria')->where('type', 'ipad')->sum('total_units') }}
                    </div>
                    <div class="progress">
                        @php
                            $ipads = $equipment->where('section', 'preescolar_primaria')->where('type', 'ipad')->first();
                            $percentage = $ipads ? ($ipads->available_units / $ipads->total_units) * 100 : 0;
                        @endphp
                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --primary: #364E76;
        --accent: #ED3236;
        --success: #28a745;
        --warning: #ffc107;
    }

    /* Headers and Text */
    .text-primary { color: var(--primary) !important; }
    h1 { font-weight: 600; }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .card-header {
        background-color: var(--primary);
        color: white;
        border-radius: 8px 8px 0 0;
        padding: 1rem 1.5rem;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 500;
    }

    .table tbody td {
        vertical-align: middle;
        padding: 0.75rem 1rem;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(54, 78, 118, 0.05);
    }

    /* Button Styles */
    .btn {
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a3d5d;
        border-color: #2a3d5d;
        transform: translateY(-2px);
    }

    .btn-warning {
        background-color: var(--warning);
        border-color: var(--warning);
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #e0a800;
        transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: var(--primary);
        color: white;
        border-radius: 8px 8px 0 0;
        padding: 1rem 1.5rem;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-header .close {
        color: white;
        opacity: 0.8;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    /* Form Controls */
    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 0.5rem 0.75rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
    }

    /* Status Badges */
    .badge {
        padding: 0.5em 1em;
        font-size: 0.85em;
        font-weight: 500;
        border-radius: 4px;
    }

    .badge-success {
        background-color: var(--success);
    }

    .badge-danger {
        background-color: var(--accent);
    }

    .badge-warning {
        background-color: var(--warning);
        color: #000;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 4px 8px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        color: white !important;
        border: 1px solid var(--primary) !important;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #2a3d5d !important;
        color: white !important;
        border: 1px solid #2a3d5d !important;
    }
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Confirmación para reiniciar inventario
    document.getElementById('resetForm').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se restablecerán todas las unidades disponibles a sus valores iniciales",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, reiniciar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // Mensaje de éxito
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>
@stop
