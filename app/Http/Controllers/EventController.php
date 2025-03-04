<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventCreated;
use App\Mail\EventConfirmed;

class EventController extends Controller
{
    protected function sendEventNotifications($event, $mailableClass)
    {
        // Obtener correos configurados para el área específica
        $config = Configuration::where('key', "events_{$event->department}_emails")->first();
        $notificationEmails = $config ? explode(',', $config->value) : [];
        
        // Enviar notificaciones a todos los correos configurados
        foreach ($notificationEmails as $email) {
            Mail::to(trim($email))->send(new $mailableClass($event));
        }

        // Enviar notificación al creador del evento
        if ($event->user && $event->user->email) {
            Mail::to($event->user->email)->send(new $mailableClass($event));
        }
    }

    public function index()
    {
        $events = Event::orderBy('service_date', 'desc')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        // Generar consecutivo automático
        $lastEvent = Event::latest()->first();
        $consecutive = $lastEvent ? 'EV-' . str_pad((intval(substr($lastEvent->consecutive, 3)) + 1), 4, '0', STR_PAD_LEFT) : 'EV-0001';
        
        $eventData = $request->all();
        $eventData['consecutive'] = $consecutive;
        
        $event = Event::create($eventData);
        
        // Enviar notificaciones
        $this->sendEventNotifications($event, EventCreated::class);

        return redirect()->route('events.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Éxito!',
                'text' => 'El evento ha sido creado exitosamente.',
            ]);
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        return redirect()->route('events.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Actualizado!',
                'text' => 'El evento ha sido actualizado exitosamente.',
            ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => '¡Eliminado!',
                'text' => 'El evento ha sido eliminado exitosamente.',
            ]);
    }

    public function calendar()
    {
        $events = Event::orderBy('service_date')->get();
        return view('events.calendar', compact('events'));
    }

    public function confirm(Event $event, Request $request)
    {
        try {
            // Verify token
            $decrypted = decrypt($request->token);
            if ($decrypted != $event->id) {
                return response()->json(['error' => 'Token inválido'], 403);
            }

            // Determine which service to confirm by checking the event's requirements
            $serviceConfirmed = false;
            
            $services = [
                'systems' => 'sistemas@tvs.edu.co',
                'purchases' => 'jefecompras@tvs.edu.co',
                'maintenance' => 'mantenimiento@tvs.edu.co',
                'general_services' => 'serviciosgenerales@tvs.edu.co',
                'communications' => 'comunicaciones@tvs.edu.co',
                'aldimark' => 'aldimark@tvs.edu.co',
                'metro_junior' => 'metrojunior@tvs.edu.co'
            ];

            // Check which service is required and not yet confirmed
            foreach ($services as $service => $email) {
                $requiredField = $service . '_required';
                $confirmedField = $service . '_confirmed';
                
                if ($event->$requiredField && !$event->$confirmedField) {
                    $event->update([
                        $confirmedField => true
                    ]);
                    $serviceConfirmed = true;
                    break;
                }
            }

            if (!$serviceConfirmed) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'No hay servicios pendientes de confirmar'], 400);
                }
                return redirect()->route('events.show', $event)
                    ->with('warning', 'Este servicio ya fue confirmado anteriormente.');
            }

            // Enviar notificaciones de confirmación
            $this->sendEventNotifications($event, EventConfirmed::class);

            if ($request->ajax()) {
                return response()->json(['message' => 'Evento confirmado exitosamente']);
            }

            return redirect()->route('events.show', $event)
                ->with('success', 'Has confirmado tu participación en el evento.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Error al confirmar el evento: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Error al confirmar el evento');
        }
    }

    public function dashboard(Request $request)
    {
        $period = $request->get('period', 'all');
        $service = $request->get('service', 'all');

        // Query base para eventos
        $query = Event::query();

        // Filtrar por período
        switch ($period) {
            case 'today':
                $query->whereDate('service_date', today());
                break;
            case 'month':
                $query->whereMonth('service_date', now()->month);
                break;
        }

        // Filtrar por servicio
        if ($service !== 'all') {
            $query->where($service . '_required', true);
        }

        // Eventos filtrados
        $events = $query->orderBy('service_date', 'desc')->get();

        // Estadísticas generales
        $totalEvents = Event::count();
        $pendingEvents = Event::where(function($query) {
            $services = ['metro_junior', 'aldimark', 'maintenance', 'general_services', 'systems', 'purchases', 'communications'];
            foreach ($services as $service) {
                $query->orWhere(function($q) use ($service) {
                    $q->where($service . '_required', true)
                      ->where($service . '_confirmed', false);
                });
            }
        })->count();

        $confirmedEvents = Event::where(function($query) {
            $services = ['metro_junior', 'aldimark', 'maintenance', 'general_services', 'systems', 'purchases', 'communications'];
            $query->where(function($q) use ($services) {
                foreach ($services as $service) {
                    $q->where(function($subq) use ($service) {
                        $subq->where($service . '_required', false)
                             ->orWhere($service . '_confirmed', true);
                    });
                }
            });
        })->count();

        // Eventos por ubicación
        $eventsByLocation = Event::select('location', \DB::raw('count(*) as total'))
            ->groupBy('location')
            ->get();

        // Eventos por servicio
        $services = [
            'metro_junior' => 'Metro Junior',
            'aldimark' => 'Aldimark',
            'maintenance' => 'Mantenimiento',
            'general_services' => 'Servicios Generales',
            'systems' => 'Sistemas',
            'purchases' => 'Compras',
            'communications' => 'Comunicaciones'
        ];

        // Eventos por servicio (Total)
        $eventsByService = [];
        foreach ($services as $key => $name) {
            $eventsByService[$name] = Event::where($key . '_required', true)->count();
        }

        // Eventos por servicio en el mes actual
        $eventsThisMonth = [];
        foreach ($services as $key => $name) {
            $count = Event::where($key . '_required', true)
                ->whereMonth('service_date', now()->month)
                ->count();
            $eventsThisMonth[$name] = $count;
        }

        // Obtener el servicio más solicitado del mes
        $maxCount = max($eventsThisMonth);
        $mostRequestedService = $maxCount > 0 ? array_search($maxCount, $eventsThisMonth) : 'N/A';

        return view('events.dashboard', compact(
            'totalEvents',
            'pendingEvents',
            'confirmedEvents',
            'eventsByLocation',
            'eventsByService',
            'eventsThisMonth',
            'mostRequestedService',
            'events',
            'services',
            'period',
            'service'
        ));
    }
}
