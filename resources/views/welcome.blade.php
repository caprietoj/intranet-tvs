@extends('adminlte::page')

@section('title', 'Dashboard TVS')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card" style="border-top: 3px solid #364E76;">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 style="color: #364E76;">Bienvenido al Portal Institucional</h2>
                    <h4 class="text-muted">{{ Auth::user()->name }}</h4>
                </div>

                <!-- Indicadores Principales -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box" style="background-color: #364E76; color: #FEFEFE;">
                            <div class="inner">
                                <h3>{{ App\Models\Ticket::where('estado', 'Abierto')->count() }}</h3>
                                <p>Tickets Activos</p>
                            </div>
                            <div class="icon text-white">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <div class="small-box-footer" style="background-color: rgba(237, 50, 54, 0.8);">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box" style="background-color: #364E76; color: #FEFEFE;">
                            <div class="inner">
                                <h3>{{ App\Models\Event::whereDate('service_date', '>=', now())->count() }}</h3>
                                <p>Eventos Programados</p>
                            </div>
                            <div class="icon text-white">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="small-box-footer" style="background-color: rgba(237, 50, 54, 0.8);">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box" style="background-color: #364E76; color: #FEFEFE;">
                            <div class="inner">
                                <h3>{{ App\Models\DocumentRequest::where('status', 'pending')->count() }}</h3>
                                <p>Solicitudes Pendientes</p>
                            </div>
                            <div class="icon text-white">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="small-box-footer" style="background-color: rgba(237, 50, 54, 0.8);">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box" style="background-color: #364E76; color: #FEFEFE;">
                            <div class="inner">
                                <h3 id="current-time">00:00:00</h3>
                                <p id="current-date">Cargando fecha...</p>
                            </div>
                            <div class="icon text-white">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="small-box-footer" style="background-color: rgba(237, 50, 54, 0.8);">
                                Hora Local
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carrusel de Avisos -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i> Avisos Importantes
                                </h3>
                            </div>
                            <div class="card-body p-0">
                                @if($announcements->count() > 0)
                                    <div id="announcements-carousel" class="carousel slide" data-ride="carousel" data-interval="8000">
                                        <div class="carousel-inner">
                                            @foreach($announcements as $index => $announcement)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    <div class="announcement-slide">
                                                        <div class="announcement-header">
                                                            <h3>{{ $announcement->title }}</h3>
                                                        </div>
                                                        <div class="announcement-content">
                                                            {!! $announcement->content !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($announcements->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-target="#announcements-carousel" data-slide="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-target="#announcements-carousel" data-slide="next">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <div class="alert alert-info m-3">
                                        <i class="fas fa-info-circle"></i> No hay avisos importantes en este momento.
                                    </div>
                                @endif
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
:root {
    --primary: #364E76;
    --accent: #ED3236;
    --background: #FEFEFE;
}

.small-box {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

.small-box .icon {
    font-size: 70px;
    opacity: 0.3;
}

.small-box:hover .icon {
    font-size: 75px;
    opacity: 0.5;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.card {
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.carousel-item {
    background-color: #FEFEFE;
}

.announcement-content {
    max-height: 400px;
    overflow-y: auto;
    padding: 20px;
    background-color: #FEFEFE;
    border-radius: 8px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: #364E76;
    padding: 25px;
    border-radius: 50%;
}

.carousel-indicators li {
    background-color: #364E76;
}

/* Estilo para el contenido del Summernote */
.announcement-content h1,
.announcement-content h2,
.announcement-content h3,
.announcement-content h4,
.announcement-content h5,
.announcement-content h6 {
    color: #364E76;
}

.announcement-content a {
    color: #ED3236;
}

.announcement-content table {
    width: 100%;
    margin-bottom: 1rem;
    border-collapse: collapse;
}

.announcement-content table td,
.announcement-content table th {
    padding: 8px;
    border: 1px solid #dee2e6;
}

.announcement-content table th {
    background-color: #364E76;
    color: #FEFEFE;
}

/* Enhanced Carousel Styles */
.announcement-slide {
    min-height: 300px;
    padding: 2rem;
    background-color: #FEFEFE;
}

.announcement-header {
    text-align: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #364E76;
}

.announcement-header h3 {
    color: #364E76;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.announcement-content {
    max-height: 400px;
    overflow-y: auto;
    padding: 1rem;
    background-color: #FEFEFE;
    border-radius: 8px;
    line-height: 1.6;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: #364E76;
    padding: 25px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.carousel-control-prev,
.carousel-control-next {
    width: 5%;
    opacity: 0.9;
}

.carousel-indicators {
    bottom: 0;
    margin-bottom: 0.5rem;
}

.carousel-indicators li {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 5px;
    background-color: #364E76;
    opacity: 0.5;
}

.carousel-indicators li.active {
    opacity: 1;
}

/* Custom Scrollbar for Announcement Content */
.announcement-content::-webkit-scrollbar {
    width: 8px;
}

.announcement-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.announcement-content::-webkit-scrollbar-thumb {
    background: #364E76;
    border-radius: 4px;
}

.announcement-content::-webkit-scrollbar-thumb:hover {
    background: #ED3236;
}

/* Animation for Carousel Items */
.carousel-item {
    transition: transform .6s ease-in-out;
}

.carousel-fade .carousel-item {
    opacity: 0;
    transition-duration: .6s;
    transition-property: opacity;
}

.carousel-fade .carousel-item.active {
    opacity: 1;
}

/* Enhanced Carousel Styles */
.custom-card {
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

.custom-card .card-header {
    background-color: #364E76;
    color: white;
    border-bottom: none;
    padding: 1rem 1.5rem;
}

.announcement-slide {
    padding: 2rem;
    background-color: #FEFEFE;
    min-height: 300px;
}

.announcement-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

.announcement-header h3 {
    color: #364E76;
    font-weight: 600;
    font-size: 1.75rem;
    margin: 0;
    padding-bottom: 1rem;
    border-bottom: 2px solid #ED3236;
}

.announcement-content {
    padding: 1rem;
    font-size: 1.1rem;
    line-height: 1.6;
    color: #495057;
    max-height: 350px;
    overflow-y: auto;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: #364E76;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.9;
    margin: 0 1rem;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: #ED3236;
    opacity: 1;
}

.carousel-control-prev i,
.carousel-control-next i {
    color: white;
    font-size: 1.2rem;
}

/* Custom Scrollbar */
.announcement-content::-webkit-scrollbar {
    width: 6px;
}

.announcement-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.announcement-content::-webkit-scrollbar-thumb {
    background: #364E76;
    border-radius: 3px;
}

.announcement-content::-webkit-scrollbar-thumb:hover {
    background: #ED3236;
}

/* Fade Animation */
.carousel-fade .carousel-item {
    opacity: 0;
    transition: opacity 0.8s ease-in-out;
}

.carousel-fade .carousel-item.active {
    opacity: 1;
}
</style>
@stop

@section('js')
<script>
function updateDateTime() {
    const now = new Date();
    const timeOptions = { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit', 
        hour12: false 
    };
    const dateOptions = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    
    document.getElementById('current-time').textContent = 
        now.toLocaleTimeString('es-CO', timeOptions);
    document.getElementById('current-date').textContent = 
        now.toLocaleDateString('es-CO', dateOptions).replace(/^\w/, (c) => c.toUpperCase());
}

setInterval(updateDateTime, 1000);
updateDateTime();

$(document).ready(function() {
    // Initialize carousel with custom options
    $('#announcements-carousel').carousel({
        interval: 8000,
        pause: "hover",
        keyboard: true
    });
});
</script>
@stop
