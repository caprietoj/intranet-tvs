@extends('adminlte::page')

@section('title', 'Bienvenido')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="text-center mb-4">
                    <!-- <img src="{{ asset('img/logo-tvs.png') }}" 
                         alt="Logo TVS" 
                         class="img-fluid mb-4"
                         style="max-width: 300px;"> -->
                    
                    <h2 class="text-primary mb-4">¡Bienvenido, {{ Auth::user()->name }}!</h2>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-gradient-info">
                            <span class="info-box-icon"><i class="far fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Fecha y Hora</span>
                                <span class="info-box-number" id="current-time"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-gradient-success">
                            <span class="info-box-icon"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Último acceso</span>
                                <span class="info-box-number">{{ Auth::user()->last_login ?? 'Primer ingreso' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ App\Models\Ticket::where('estado', 'Abierto')->count() }}</h3>
                                <p>Tickets Pendientes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <a href="{{ route('tickets.index') }}" class="small-box-footer">
                                Ver tickets <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ App\Models\Event::whereDate('service_date', '>=', now())->count() }}</h3>
                                <p>Eventos Próximos</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <a href="{{ route('events.index') }}" class="small-box-footer">
                                Ver eventos <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ App\Models\DocumentRequest::where('status', 'pending')->count() }}</h3>
                                <p>Solicitudes Pendientes</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <a href="{{ route('document-requests.index') }}" class="small-box-footer">
                                Ver solicitudes <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i> Anuncios Importantes
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h5><i class="icon fas fa-info"></i> Bienvenido a la Intranet TVS</h5>
                                    <p>Este es tu portal para gestionar tickets, eventos y documentos. Si necesitas ayuda, no dudes en contactar al equipo de sistemas.</p>
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
.small-box .icon {
    font-size: 70px;
}
.small-box:hover .icon {
    font-size: 75px;
}
.alert {
    margin-bottom: 0;
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
        now.toLocaleDateString('es-CO', options).replace(/^\w/, (c) => c.toUpperCase());
}

setInterval(updateTime, 1000);
updateTime();
</script>
@stop
