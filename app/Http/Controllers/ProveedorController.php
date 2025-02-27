<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'nit' => 'required|unique:proveedors',
            'direccion' => 'required',
            'ciudad' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:proveedors',
            'persona_contacto' => 'required',
            'servicio_producto' => 'required',
            'proveedor_critico' => 'required|boolean',
            'alto_riesgo' => 'required|boolean',
            'criterios_tecnicos' => 'required|numeric|min:0|max:100',
            'camara_comercio' => 'nullable|file|mimes:pdf|max:2048',
            'rut' => 'nullable|file|mimes:pdf|max:2048',
            'cedula_representante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certificacion_bancaria' => 'nullable|file|mimes:pdf|max:2048',
            'seguridad_social' => 'nullable|file|mimes:pdf|max:2048',
            'certificacion_alturas' => 'nullable|file|mimes:pdf|max:2048',
            'matriz_peligros' => 'nullable|file|mimes:pdf|max:2048',
            'matriz_epp' => 'nullable|file|mimes:pdf|max:2048',
            'estadisticas' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $proveedor = Proveedor::create($request->except([
            'camara_comercio', 'rut', 'cedula_representante', 'certificacion_bancaria',
            'seguridad_social', 'certificacion_alturas', 'matriz_peligros',
            'matriz_epp', 'estadisticas'
        ]));
        
        $puntajes = [
            'puntaje_forma_pago' => $this->calcularPuntajeFormaPago($request->forma_pago),
            'puntaje_referencias' => $this->calcularPuntajeReferencias($request->referencias_comerciales),
            'puntaje_descuento' => $this->calcularPuntajeDescuento($request->descuento),
            'puntaje_cobertura' => $this->calcularPuntajeCobertura($request->cobertura),
            'puntaje_valores_agregados' => $this->calcularPuntajeValoresAgregados($request->valores_agregados),
            'puntaje_precios' => $this->calcularPuntajePrecios($request->nivel_precios),
            'puntaje_criterios_tecnicos' => $request->criterios_tecnicos ?? 60
        ];
        
        $proveedor->update($puntajes);
        $proveedor->calcularPuntajeTotal();

        $proveedorPath = 'proveedores/' . Str::slug($proveedor->nombre) . '_' . $proveedor->id;

        $documentos = [
            'camara_comercio', 'rut', 'cedula_representante', 'certificacion_bancaria',
            'seguridad_social', 'certificacion_alturas', 'matriz_peligros',
            'matriz_epp', 'estadisticas'
        ];

        foreach ($documentos as $documento) {
            if ($request->hasFile($documento)) {
                try {
                    $file = $request->file($documento);
                    $filename = $documento . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($proveedorPath, $filename, 'public');
                    
                    if ($path) {
                        $proveedor->{$documento . '_path'} = $path;
                    }
                } catch (\Exception $e) {
                    \Log::error("Error al guardar el documento $documento: " . $e->getMessage());
                }
            }
        }

        $proveedor->save();
        
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $request->validate([
            'nombre' => 'required',
            'nit' => 'required|unique:proveedors,nit,' . $proveedor->id,
            'direccion' => 'required',
            'ciudad' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:proveedors,email,' . $proveedor->id,
            'persona_contacto' => 'required',
            'servicio_producto' => 'required',
            'proveedor_critico' => 'required|boolean',
            'alto_riesgo' => 'required|boolean',
            'criterios_tecnicos' => 'required|numeric|min:0|max:100',
            'camara_comercio' => 'nullable|file|mimes:pdf|max:2048',
            'rut' => 'nullable|file|mimes:pdf|max:2048',
            'cedula_representante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certificacion_bancaria' => 'nullable|file|mimes:pdf|max:2048',
            'seguridad_social' => 'nullable|file|mimes:pdf|max:2048',
            'certificacion_alturas' => 'nullable|file|mimes:pdf|max:2048',
            'matriz_peligros' => 'nullable|file|mimes:pdf|max:2048',
            'matriz_epp' => 'nullable|file|mimes:pdf|max:2048',
            'estadisticas' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $puntajes = [
            'puntaje_forma_pago' => $this->calcularPuntajeFormaPago($request->forma_pago),
            'puntaje_referencias' => $this->calcularPuntajeReferencias($request->referencias_comerciales),
            'puntaje_descuento' => $this->calcularPuntajeDescuento($request->descuento),
            'puntaje_cobertura' => $this->calcularPuntajeCobertura($request->cobertura),
            'puntaje_valores_agregados' => $this->calcularPuntajeValoresAgregados($request->valores_agregados),
            'puntaje_precios' => $this->calcularPuntajePrecios($request->nivel_precios),
            'puntaje_criterios_tecnicos' => $request->criterios_tecnicos ?? 60
        ];

        $proveedorPath = 'proveedores/' . Str::slug($proveedor->nombre) . '_' . $proveedor->id;
        
        foreach (['camara_comercio', 'rut', 'cedula_representante', 'certificacion_bancaria',
            'seguridad_social', 'certificacion_alturas', 'matriz_peligros',
            'matriz_epp', 'estadisticas'] as $documento) {
            if ($request->hasFile($documento)) {
                try {
                    if ($proveedor->{$documento . '_path'}) {
                        Storage::disk('public')->delete($proveedor->{$documento . '_path'});
                    }

                    $file = $request->file($documento);
                    $filename = $documento . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($proveedorPath, $filename, 'public');
                    
                    if ($path) {
                        $proveedor->{$documento . '_path'} = $path;
                    }
                } catch (\Exception $e) {
                    \Log::error("Error al actualizar el documento $documento: " . $e->getMessage());
                }
            }
        }

        $proveedor->update(array_merge($request->all(), $puntajes));
        $proveedor->calcularPuntajeTotal();
        
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }

    private function calcularPuntajeFormaPago($formaPago)
    {
        return match($formaPago) {
            '0-30' => 20,
            '31-60' => 50,
            '61-90' => 100,
            default => 0
        };
    }

    private function calcularPuntajeReferencias($referencias)
    {
        return match($referencias) {
            '3' => 100,
            '2' => 60,
            '1' => 30,
            default => 0
        };
    }

    private function calcularPuntajeDescuento($descuento)
    {
        return match($descuento) {
            '15' => 100,
            '12' => 75,
            '10' => 50,
            '5' => 25,
            '0' => 0,
            default => 0
        };
    }

    private function calcularPuntajeCobertura($cobertura)
    {
        return match($cobertura) {
            '4' => 100,
            '2' => 70,
            '1' => 50,
            default => 0
        };
    }

    private function calcularPuntajeValoresAgregados($valores)
    {
        if (empty($valores)) {
            return 0;
        }
        return 80;
    }

    private function calcularPuntajePrecios($nivel)
    {
        return match($nivel) {
            'bajo' => 100,
            'promedio' => 50,
            'alto' => 0,
            default => 0
        };
    }
}