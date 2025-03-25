<?php

namespace App\Http\Controllers;

use App\Models\PuntoControl;
use App\Models\Lugar;
use Illuminate\Http\Request;

class PuntoControlController extends Controller
{
    public function index()
    {
        // Cargamos la relación 'lugar'
        $puntos = PuntoControl::with('lugar')->get();
        return view('admin.puntos_control.index', compact('puntos'));
    }

    public function create()
    {
        // Lista de lugares para asignar un punto de control a un lugar
        $lugares = Lugar::all();
        return view('admin.puntos_control.create', compact('lugares'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lugar_id'    => 'required|exists:lugares,id',
            'descripcion' => 'required|string',
            'pista'       => 'required|string',
            'prueba'      => 'required|string',
        ]);

        PuntoControl::create($request->only('lugar_id','descripcion','pista','prueba'));

        return redirect()->route('admin.puntos-control.index')
                         ->with('success','Punto de control creado correctamente.');
    }

    public function edit(PuntoControl $puntos_control)
    {
        $lugares = Lugar::all();
        return view('admin.puntos_control.edit', [
            'puntos_control' => $puntos_control,
            'lugares'        => $lugares
        ]);
    }

    public function update(Request $request, PuntoControl $puntos_control)
    {
        $request->validate([
            'lugar_id'    => 'required|exists:lugares,id',
            'descripcion' => 'required|string',
            'pista'       => 'required|string',
            'prueba'      => 'required|string',
        ]);

        $puntos_control->update($request->only('lugar_id','descripcion','pista','prueba'));

        return redirect()->route('admin.puntos-control.index')
                         ->with('success','Punto de control actualizado correctamente.');
    }

    public function destroy(PuntoControl $puntos_control)
    {
        $puntos_control->delete();
        return redirect()->route('admin.puntos-control.index')
                         ->with('success','Punto de control eliminado correctamente.');
    }

}
