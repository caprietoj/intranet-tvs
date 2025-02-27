<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionProveedor;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluacionProveedorController extends Controller
{
    public function index()
    {
        $evaluaciones = EvaluacionProveedor::with('proveedor')->get();
        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        $evaluador = Auth::user()->name;
        return view('evaluaciones.create', compact('proveedores', 'evaluador'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedors,id',
            'numero_contrato' => 'required|string',
            'fecha_evaluacion' => 'required|date',
            'lugar_evaluacion' => 'required|string',
            'cumplimiento_entrega' => 'required|numeric|between:0,5',
            'calidad_especificaciones' => 'required|numeric|between:0,5',
            'documentacion_garantias' => 'required|numeric|between:0,5',
            'servicio_postventa' => 'required|numeric|between:0,5',
            'precio' => 'required|numeric|between:0,5',
            'capacidad_instalada' => 'required|numeric|between:0,5',
            'soporte_tecnico' => 'required|numeric|between:0,5',
            'observaciones' => 'nullable|string',
            'evaluado_por' => 'required|string',
        ]);

        $evaluacion = new EvaluacionProveedor($request->all());
        $evaluacion->evaluado_por = Auth::user()->name;
        $evaluacion->puntaje_total = $evaluacion->calcularPuntajeTotal();
        $evaluacion->save();

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación registrada exitosamente.');
    }

    public function show($id)
    {
        $evaluacion = EvaluacionProveedor::with('proveedor')->findOrFail($id);
        return view('evaluaciones.show', compact('evaluacion'));
    }

    public function edit($id)
    {
        $evaluacion = EvaluacionProveedor::with('proveedor')->findOrFail($id);
        $proveedores = Proveedor::all();
        return view('evaluaciones.edit', compact('evaluacion', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $evaluacion = EvaluacionProveedor::findOrFail($id);
        
        $request->validate([
            'proveedor_id' => 'required|exists:proveedors,id',
            'numero_contrato' => 'required|string',
            'fecha_evaluacion' => 'required|date',
            'lugar_evaluacion' => 'required|string',
            'cumplimiento_entrega' => 'required|numeric|between:0,5',
            'calidad_especificaciones' => 'required|numeric|between:0,5',
            'documentacion_garantias' => 'required|numeric|between:0,5',
            'servicio_postventa' => 'required|numeric|between:0,5',
            'precio' => 'required|numeric|between:0,5',
            'capacidad_instalada' => 'required|numeric|between:0,5',
            'soporte_tecnico' => 'required|numeric|between:0,5',
            'observaciones' => 'nullable|string',
            'evaluado_por' => 'required|string',
        ]);

        $evaluacion->fill($request->all());
        $evaluacion->puntaje_total = $evaluacion->calcularPuntajeTotal();
        $evaluacion->save();

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación actualizada exitosamente.');
    }

    // ...otros métodos del controlador...
}
