<?php

// app/Http/Controllers/TicketController.php
namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // Mostrar listado (para DataTables)
    public function index(Request $request)
    {
        // Si la petición es AJAX, se envían los datos en JSON
        if ($request->ajax()) {
            $tickets = Ticket::with('user')->get();
            return response()->json(['data' => $tickets]);
        }
        // Para la vista, se pueden enviar también los tickets
        $tickets = Ticket::with('user')->get();
        return view('tickets.index', compact('tickets'));
    }

    // Formulario para crear un nuevo ticket
    public function create()
    {
        return view('tickets.create');
    }

    // Guardar un nuevo ticket (con validaciones y usuario autenticado)

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'titulo'             => 'required|max:255',
        'descripcion'        => 'required',
        // Se elimina la validación del campo 'estado'
        'prioridad'          => 'required|in:Baja,Media,Alta',
        'tipo_requerimiento' => 'required|in:Hardware,Software,Mantenimiento,Instalación,Conectividad'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $ticket = Ticket::create([
        'titulo'             => $request->titulo,
        'descripcion'        => $request->descripcion,
        'estado'             => 'Abierto', // Valor por defecto al crear el ticket
        'prioridad'          => $request->prioridad,
        'tipo_requerimiento' => $request->tipo_requerimiento,
        'user_id'            => Auth::id(),
    ]);

    return response()->json(['message' => 'Ticket creado exitosamente', 'ticket' => $ticket], 201);
    }


    // Mostrar detalles de un ticket
    public function show($id)
    {
        $ticket = Ticket::with('user')->findOrFail($id);
        return view('tickets.show', compact('ticket'));
    }

    // Formulario para editar un ticket
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('tickets.edit', compact('ticket'));
    }

    // Actualizar un ticket (retorna JSON para manejo con AJAX)
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'titulo'             => 'required|max:255',
            'descripcion'        => 'required',
            'estado'             => 'required|in:Abierto,En Proceso,Cerrado',
            'prioridad'          => 'required|in:Baja,Media,Alta',
            'tipo_requerimiento' => 'required|in:Hardware,Software,Mantenimiento,Instalación,Conectividad'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $ticket->update($request->only('titulo', 'descripcion', 'estado', 'prioridad', 'tipo_requerimiento'));

        return response()->json(['message' => 'Ticket actualizado exitosamente', 'ticket' => $ticket], 200);
    }

    // Eliminar un ticket (con respuesta JSON para AJAX)
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return response()->json(['message' => 'Ticket eliminado exitosamente'], 200);
    }
}
