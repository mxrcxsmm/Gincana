<?php

namespace App\Http\Controllers;

use App\Models\Gimcana;
use App\Models\PuntoControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GimcanaController extends Controller
{
    // Listado de gimcanas
    public function index()
    {
        $gimcanas = Gimcana::orderBy('id', 'desc')->get();
        return view('admin.gimcanas.index', compact('gimcanas'));
    }

    // Formulario para crear una nueva gimcana
    public function create()
    {
        // Carga la relación 'lugar' con cada punto de control
        $puntos = PuntoControl::with('lugar')->get();
        return view('admin.gimcanas.create', compact('puntos'));
    }

    // Guardar nueva gimcana (con try/catch y DB::beginTransaction())
    public function store(Request $request)
    {
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'descripcion'    => 'required|string',
            'puntos_control' => 'required|array|min:4',
            'puntos_control.*' => 'exists:puntos_control,id',
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear la gimcana
            $gimcana = Gimcana::create([
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            // 2. Sincronizar los puntos de control en la tabla pivote
            $gimcana->puntosControl()->sync($request->puntos_control);

            DB::commit();

            return redirect()->route('admin.gimcanas.index')
                ->with('success', 'Gimcana creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.gimcanas.index')
                ->with('error', 'Ocurrió un error al crear la gimcana.');
        }
    }

    // Formulario para editar una gimcana
    public function edit(Gimcana $gimcana)
    {
        $puntos = PuntoControl::with('lugar')->get();
        $puntosSeleccionados = $gimcana->puntosControl->pluck('id')->toArray();
        return view('admin.gimcanas.edit', compact('gimcana', 'puntos', 'puntosSeleccionados'));
    }

    // Actualizar gimcana (con try/catch y DB::beginTransaction())
    public function update(Request $request, Gimcana $gimcana)
    {
        $request->validate([
            'nombre'         => 'required|string|max:255',
            'descripcion'    => 'required|string',
            'puntos_control' => 'required|array|min:4',
            'puntos_control.*' => 'exists:puntos_control,id',
        ]);

        try {
            DB::beginTransaction();

            // 1. Actualizar la gimcana
            $gimcana->update([
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            // 2. Sincronizar los puntos de control
            $gimcana->puntosControl()->sync($request->puntos_control);

            DB::commit();

            return redirect()->route('admin.gimcanas.index')
                ->with('success', 'Gimcana actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.gimcanas.index')
                ->with('error', 'Ocurrió un error al actualizar la gimcana.');
        }
    }

    // Eliminar gimcana
    public function destroy(Gimcana $gimcana)
    {
        $gimcana->delete();
        return redirect()->route('admin.gimcanas.index')
            ->with('success', 'Gimcana eliminada correctamente.');
    }
}
