@extends('adminlte::page')

@section('title', 'Inventario Inicial')

@section('content_header')
    <h1 class="text-primary mb-4">Inventario Inicial de Equipos</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Resumen del Inventario -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-primary card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-school mr-2"></i>
                        Resumen Bachillerato
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-primary">
                                <span class="info-box-icon"><i class="fas fa-laptop"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-bold">Portátiles</span>
                                    <span class="info-box-number">
                                        {{ $equipment->where('section', 'bachillerato')->where('type', 'laptop')->sum('total_units') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="fas fa-tablet-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-bold">iPads</span>
                                    <span class="info-box-number">
                                        {{ $equipment->where('section', 'bachillerato')->where('type', 'ipad')->sum('total_units') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-child mr-2"></i>
                        Resumen Preescolar y Primaria
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-box bg-gradient-success">
                        <span class="info-box-icon"><i class="fas fa-tablet-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-bold">iPads</span>
                            <span class="info-box-number">
                                {{ $equipment->where('section', 'preescolar_primaria')->where('type', 'ipad')->sum('total_units') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Formulario para Bachillerato -->
        <div class="col-md-6">
            <div class="card card-primary card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Registrar Equipos - Bachillerato
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('equipment.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="section" value="bachillerato">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-laptop mr-1"></i> Portátiles
                            </label>
                            <div class="input-group">
                                <input type="number" name="total_units" class="form-control" required min="1" placeholder="Cantidad">
                                <input type="hidden" name="type" value="laptop">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Registrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('equipment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="bachillerato">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-tablet-alt mr-1"></i> iPads
                            </label>
                            <div class="input-group">
                                <input type="number" name="total_units" class="form-control" required min="1" placeholder="Cantidad">
                                <input type="hidden" name="type" value="ipad">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-plus"></i> Registrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Formulario para Preescolar y Primaria -->
        <div class="col-md-6">
            <div class="card card-success card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Registrar Equipos - Preescolar y Primaria
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('equipment.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="preescolar_primaria">
                        <input type="hidden" name="type" value="ipad">
                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-tablet-alt mr-1"></i> iPads
                            </label>
                            <div class="input-group">
                                <input type="number" name="total_units" class="form-control" required min="1" placeholder="Cantidad">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Registrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
        --info: #17a2b8;
    }

    .text-primary { color: var(--primary) !important; }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-outline {
        border-top: 3px solid var(--primary);
    }

    .card-primary.card-outline {
        border-top-color: var(--primary);
    }

    .card-success.card-outline {
        border-top-color: var(--success);
    }

    .info-box {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        min-height: 120px;
        background: white;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, var(--primary), #4a6491);
        color: white;
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, var(--info), #2dcee3);
        color: white;
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, var(--success), #34ce57);
        color: white;
    }

    .info-box-icon {
        font-size: 2.5rem;
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 1rem;
    }

    .info-box-content {
        padding: 1rem;
    }

    .info-box-number {
        font-size: 2rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .info-box-text {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 0.5rem 1rem;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
    }

    .input-group {
        margin-bottom: 1rem;
    }

    .input-group-append .btn {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a3d5d;
        border-color: #2a3d5d;
    }

    .btn-info {
        background-color: var(--info);
        border-color: var(--info);
    }

    .btn-success {
        background-color: var(--success);
        border-color: var(--success);
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,0.125);
        padding: 1.25rem;
    }

    .card-header .card-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .card-header i {
        margin-right: 0.5rem;
        color: var(--primary);
    }

    label.font-weight-bold {
        color: #495057;
        margin-bottom: 0.5rem;
    }
</style>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mensajes de éxito o error
    @if(session('success'))
        Swal.fire({
            type: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            type: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    @endif
});
</script>
@stop
