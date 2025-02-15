@extends('adminlte::page')

@section('title', 'Gestionar Inventario')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestionar Inventario</h1>
        <form action="{{ route('equipment.reset') }}" method="POST" class="d-inline" id="resetForm">
            @csrf
            <button type="submit" class="btn btn-warning" id="resetInventory">
                <i class="fas fa-sync"></i> Reiniciar Inventario
            </button>
        </form>
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
.info-box {
    min-height: 120px;
    transition: all 0.3s ease;
    margin-bottom: 0;
}
.info-box:hover {
    transform: translateY(-5px);
}
.info-box-icon {
    width: 80px;
    height: 80px;
    font-size: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}
.info-box-text {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}
.progress-description {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}
.progress {
    height: 15px;
    border-radius: 10px;
}
.progress-bar {
    background-color: rgba(255,255,255,0.7);
}
.card {
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
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
