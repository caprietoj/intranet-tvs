<?php

namespace App\Http\Controllers;

use App\Models\ComprasThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThresholdComprasController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    // Formulario para crear un nuevo threshold para Compras
    public function createCompras()
    {
         return view('threshold.compras.create');
    }

    // Almacena el threshold creado para Compras
    public function storeCompras(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'kpi_name' => 'required|string|max:255',
              'value'    => 'required|numeric|min:0|max:100',
         ]);

         if ($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
         }

         ComprasThreshold::create([
              'area'     => 'compras',
              'kpi_name' => $request->kpi_name,
              'value'    => $request->value,
         ]);

         return redirect()->route('umbral.compras.show')->with('success', 'Threshold de Compras creado exitosamente.');
    }

    // Formulario para editar el threshold para Compras
    public function editCompras()
    {
         $threshold = ComprasThreshold::where('area', 'compras')->first();
         if (!$threshold){
              return redirect()->route('umbral.compras.create');
         }
         return view('threshold.compras.edit', compact('threshold'));
    }

    // Actualiza el threshold para Compras
    public function updateCompras(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'kpi_name' => 'required|string|max:255',
              'value'    => 'required|numeric|min:0|max:100'
         ]);

         if ($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
         }

         $threshold = ComprasThreshold::where('area', 'compras')->first();
         if (!$threshold) {
              $threshold = ComprasThreshold::create([
                   'area'     => 'compras',
                   'kpi_name' => $request->kpi_name,
                   'value'    => $request->value,
              ]);
         } else {
              $threshold->update([
                   'kpi_name' => $request->kpi_name,
                   'value'    => $request->value,
              ]);
         }

         return redirect()->route('umbral.compras.show')->with('success', 'Threshold de Compras actualizado exitosamente.');
    }

    // Muestra en una tabla todos los thresholds configurados para Compras
    public function showCompras()
    {
         $thresholds = ComprasThreshold::where('area', 'compras')->get();
         return view('threshold.compras.show', compact('thresholds'));
    }

    // Elimina un threshold para Compras (usado con SweetAlert2 y AJAX)
    public function destroyCompras($id)
    {
         $threshold = ComprasThreshold::findOrFail($id);
         $threshold->delete();
         return response()->json(['message' => 'Threshold de Compras eliminado exitosamente.'], 200);
    }
}
