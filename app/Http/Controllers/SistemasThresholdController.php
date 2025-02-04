<?php

namespace App\Http\Controllers;

use App\Models\SistemasThreshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SistemasThresholdController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    // Muestra el formulario para crear un nuevo threshold para Sistemas
    public function createSistemas()
    {
         return view('threshold.sistemas.create');
    }

    // Almacena el threshold para Sistemas
    public function storeSistemas(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'kpi_name' => 'required|string|max:255',
              'value'    => 'required|numeric|min:0|max:100'
         ]);

         if ($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
         }

         SistemasThreshold::create([
              'kpi_name' => $request->kpi_name,
              'value'    => $request->value,
         ]);

         return redirect()->route('umbral.sistemas.index')->with('success', 'Threshold de Sistemas creado exitosamente.');
    }

    // Muestra el formulario para editar el threshold para Sistemas
    public function editSistemas()
    {
         $threshold = SistemasThreshold::first();
         if (!$threshold){
              return redirect()->route('umbral.sistemas.create');
         }
         return view('threshold.sistemas.edit', compact('threshold'));
    }

    // Actualiza el threshold para Sistemas
    public function updateSistemas(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'kpi_name' => 'required|string|max:255',
              'value'    => 'required|numeric|min:0|max:100'
         ]);

         if ($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
         }

         $threshold = SistemasThreshold::first();
         if (!$threshold) {
              $threshold = SistemasThreshold::create([
                   'kpi_name' => $request->kpi_name,
                   'value'    => $request->value,
              ]);
         } else {
              $threshold->update([
                   'kpi_name' => $request->kpi_name,
                   'value'    => $request->value,
              ]);
         }

         return redirect()->route('umbral.sistemas.index')->with('success', 'Threshold de Sistemas actualizado exitosamente.');
    }

    // Muestra en una tabla todos los thresholds configurados para Sistemas
    public function indexSistemas()
    {
         $thresholds = SistemasThreshold::all();
         return view('threshold.sistemas.index', compact('thresholds'));
    }

    // Elimina un threshold para Sistemas (vía AJAX con SweetAlert2)
    public function destroySistemas($id)
    {
         $threshold = SistemasThreshold::findOrFail($id);
         $threshold->delete();
         return response()->json(['message' => 'Threshold de Sistemas eliminado exitosamente.'], 200);
    }
}
