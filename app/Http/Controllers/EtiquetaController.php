<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function index()
    {
        $etiquetas = Etiqueta::all();
        return view('admin.etiquetas.index', compact('etiquetas'));
    }

    public function create()
    {
        return view('admin.etiquetas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'color'  => 'required|string|max:7', // #FFFFFF
        ]);

        Etiqueta::create($request->only('nombre','color'));

        return redirect()->route('admin.etiquetas.index')
                         ->with('success','Etiqueta creada correctamente.');
    }

    public function edit(Etiqueta $etiqueta)
    {
        return view('admin.etiquetas.edit', compact('etiqueta'));
    }

    public function update(Request $request, Etiqueta $etiqueta)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'color'  => 'required|string|max:7',
        ]);

        $etiqueta->update($request->only('nombre','color'));

        return redirect()->route('admin.etiquetas.index')
                         ->with('success','Etiqueta actualizada correctamente.');
    }

    public function destroy(Etiqueta $etiqueta)
    {
        // Ojo: si la etiqueta está relacionada con lugares, 
        // Eloquent se encargará de la eliminación en la tabla pivote.
        $etiqueta->delete();

        return redirect()->route('admin.etiquetas.index')
                         ->with('success','Etiqueta eliminada correctamente.');
    }
}
