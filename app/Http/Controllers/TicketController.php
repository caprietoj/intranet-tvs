<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Muestra el listado de tickets.
     */
    public function index(Request $request)
    {
        // Los administradores ven todos los tickets; los demás solo sus tickets.
        if (auth()->user()->hasRole('admin')) {
            $tickets = Ticket::with('user', 'tecnico')->get();
        } else {
            $tickets = Ticket::with('user', 'tecnico')
                ->where('user_id', auth()->id())
                ->get();
        }

        if ($request->ajax()) {
            return response()->json(['data' => $tickets]);
        }

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Muestra el formulario para crear un ticket.
     * En esta acción NO se asigna técnico.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Almacena un nuevo ticket.
     * Se omite la asignación de técnico en este proceso.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'             => 'required|string|max:255',
            'descripcion'        => 'required|string',
            'tipo_requerimiento' => 'required|string|in:Hardware,Software,Mantenimiento,Instalación,Conectividad',
            'prioridad'          => 'required|string|in:Baja,Media,Alta',
        ]);

        $data['estado']  = 'Abierto';
        $data['user_id'] = auth()->id();
        // No se asigna técnico en la creación
        $ticket = Ticket::create($data);

        return response()->json([
            'message' => 'Ticket creado exitosamente',
            'ticket'  => $ticket
        ], 201);
    }

    /**
     * Muestra el detalle de un ticket.
     */
    public function show($id)
    {
        $ticket = Ticket::with('user', 'tecnico')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Muestra el formulario para editar un ticket.
     * Aquí se permite asignar el técnico.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        // Se consultan los usuarios cuyo cargo sea "Tecnico" o "Auxiliar"
        $tecnicos = User::whereIn('cargo', ['Tecnico', 'Auxiliar'])->get();
        return view('tickets.edit', compact('ticket', 'tecnicos'));
    }

    /**
     * Actualiza un ticket existente.
     * Permite asignar (o cambiar) el técnico al ticket.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titulo'             => 'required|string|max:255',
            'descripcion'        => 'required|string',
            'estado'             => 'required|in:Abierto,En Proceso,Cerrado',
            'prioridad'          => 'required|string|in:Baja,Media,Alta',
            'tipo_requerimiento' => 'required|string|in:Hardware,Software,Mantenimiento,Instalación,Conectividad',
            'tecnico_id'         => 'nullable|exists:users,id',
        ]);

        if (!empty($data['tecnico_id'])) {
            $tecnico = User::find($data['tecnico_id']);
            if (!in_array($tecnico->cargo, ['Tecnico', 'Auxiliar'])) {
                return response()->json([
                    'errors' => ['tecnico_id' => ['El usuario seleccionado no es un técnico o auxiliar válido.']]
                ], 422);
            }
        }

        $ticket = Ticket::findOrFail($id);
        $ticket->update($data);

        return response()->json([
            'message' => 'Ticket actualizado exitosamente',
            'ticket'  => $ticket
        ], 200);
    }

    /**
     * Elimina un ticket.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json([
            'message' => 'Ticket eliminado exitosamente'
        ], 200);
    }
}