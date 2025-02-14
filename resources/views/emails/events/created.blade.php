@component('mail::message')
# Nuevo Evento Requiere su Atención

Se ha creado un nuevo evento que requiere su participación:

**Nombre del evento:** {{ $event->event_name }}  
**Fecha:** {{ $event->service_date->format('d/m/Y') }}  
**Hora:** {{ $event->event_time }}  
**Lugar:** {{ $event->location }}  
**Responsable:** {{ $event->responsible }}

@component('mail::button', ['url' => route('events.show', $event->id)])
Ver Detalles del Evento
@endcomponent

@component('mail::button', ['url' => route('events.confirm', ['event' => $event->id, 'token' => encrypt($event->id)]), 'color' => 'success'])
Confirmar Participación
@endcomponent

Por favor, revise los detalles del evento y confirme su participación.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
