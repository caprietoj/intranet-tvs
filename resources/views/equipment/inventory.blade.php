@extends('adminlte::page')

@section('title', 'Inventario Inicial de Equipos')

@section('content_header')
    <h1>Inventario Inicial de Equipos</h1>
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
.info-box {
    min-height: 120px;
    padding: 1.5rem;
    margin-bottom: 0;
    transition: all 0.3s ease;
}
.info-box:hover {
    transform: translateY(-5px);
}
.info-box-icon {
    font-size: 3rem;
    margin-right: 1.5rem;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.info-box-number {
    font-size: 2.5rem;
    font-weight: bold;
    margin-top: 0.5rem;
}
.info-box-text {
    font-size: 1.2rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
}
.form-group {
    margin-bottom: 2rem;
}
.input-group .form-control {
    height: calc(2.5rem + 2px);
}
.btn {
    padding: 0.5rem 1.5rem;
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
