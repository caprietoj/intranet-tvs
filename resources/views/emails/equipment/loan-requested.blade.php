@component('mail::message')
# Nueva Solicitud de Préstamo de Equipo

Se ha registrado una nueva solicitud de préstamo:

**Detalles:**
- **Solicitante:** {{ $loan->user->name }}
- **Sección:** {{ $loan->section }}
- **Grado:** {{ $loan->grade }}
- **Fecha:** {{ $loan->loan_date->format('d/m/Y') }}
- **Horario:** {{ \Carbon\Carbon::parse($loan->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($loan->end_time)->format('H:i') }}
- **Cantidad:** {{ $loan->units_requested }} unidad(es)

@component('mail::button', ['url' => route('equipment.loans')])
Ver Solicitud
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
