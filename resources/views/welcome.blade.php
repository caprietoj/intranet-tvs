@extends('adminlte::page')

@section('title', 'Bienvenido')

@section('content_header')
    <h1>Bienvenido</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" 
                         alt="Logo" 
                         class="img-fluid mb-4"
                         style="max-width: 200px;">
                    
                    <h2 class="mb-4">¡Bienvenido, {{ Auth::user()->name }}!</h2>
                    
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon"><i class="far fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Fecha y Hora Actual</span>
                                    <span class="info-box-number">
                                        <span id="current-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
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
    min-height: 100px;
}
.info-box-number {
    font-size: 1.5rem;
}
</style>
@stop

@section('js')
<script>
function updateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    document.getElementById('current-time').textContent = 
        now.toLocaleDateString('es-CO', options);
}

// Actualizar cada segundo
setInterval(updateTime, 1000);
updateTime(); // Llamada inicial
</script>
@stop
