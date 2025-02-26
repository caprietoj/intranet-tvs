@extends('adminlte::page')

@section('title', 'Dashboard TVS')

@section('content')
<div class="container-fluid welcome-container">
    <!-- Header Section with Logo -->
    <div class="welcome-header">
        <img src="{{ asset('img/the_victoria.png') }}" alt="Logo Victoria School" class="welcome-logo">
        <div class="welcome-title">
            <h1>Portal Institucional</h1>
            <p class="welcome-subtitle">Bienvenido(a), {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon"><i class="fas fa-ticket-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tickets Activos</span>
                    <span class="info-box-number">{{ App\Models\Ticket::where('estado', 'Abierto')->count() }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Eventos Programados</span>
                    <span class="info-box-number">{{ App\Models\Event::whereDate('service_date', '>=', now())->count() }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Solicitudes Pendientes</span>
                    <span class="info-box-number">{{ App\Models\DocumentRequest::where('status', 'pending')->count() }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="info-box">
                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Hora Local</span>
                    <span class="info-box-number" id="current-time">00:00:00</span>
                    <span class="info-box-text" id="current-date">Cargando fecha...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card announcement-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bullhorn mr-2"></i>Avisos Importantes
                    </h3>
                </div>
                <div class="card-body">
                    @if($announcements->count() > 0)
                        <div id="announcements-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($announcements as $index => $announcement)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div class="announcement-content">
                                            <h4 class="announcement-title">{{ $announcement->title }}</h4>
                                            <div class="announcement-body">
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
                            <i class="fas fa-info-circle mr-2"></i>No hay avisos importantes en este momento.
                        </div>
                    @endif
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
        --secondary: #ED3236;
        --light: #FEFEFE;
    }

    .welcome-container {
        padding: 2rem;
    }

    .welcome-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, #1a2036 100%);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .welcome-logo {
        height: 100px;
        object-fit: contain;
    }

    .welcome-title {
        color: var(--light);
    }

    .welcome-title h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin: 0;
    }

    .info-box {
        display: flex;
        background: var(--light);
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-5px);
    }

    .info-box-icon {
        background: var(--primary);
        color: var(--light);
        width: 70px;
        height: 70px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-right: 1rem;
    }

    .info-box-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-box-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary);
    }

    .info-box-text {
        color: #666;
        font-size: 1rem;
    }

    .announcement-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .announcement-card .card-header {
        background: var(--primary);
        color: var(--light);
        padding: 1rem 1.5rem;
    }

    .announcement-content {
        padding: 2rem;
    }

    .announcement-title {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--secondary);
    }

    .announcement-body {
        color: #444;
        line-height: 1.6;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        background: var(--primary);
        border-radius: 50%;
        opacity: 0.8;
        top: 50%;
        transform: translateY(-50%);
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
        background: var(--secondary);
    }

    @media (max-width: 768px) {
        .welcome-header {
            flex-direction: column;
            text-align: center;
        }

        .welcome-logo {
            height: 80px;
        }

        .welcome-title h1 {
            font-size: 2rem;
        }
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
