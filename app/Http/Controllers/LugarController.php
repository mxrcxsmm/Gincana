<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LugarController extends Controller
{
    /**
     * Lista de lugares en el panel de administración.
     */
    public function index()
    {
        $lugares = Lugar::with('etiquetas')->orderBy('id', 'desc')->get();
        return view('admin.lugares.index', compact('lugares'));
    }

    /**
     * Formulario para crear un nuevo lugar.
     */
    public function create()
    {
        $etiquetas = Etiqueta::all();
        return view('admin.lugares.create', compact('etiquetas'));
    }

    /**
     * Almacena un nuevo lugar en la BD (con transacción).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'required|string',
            'direccion'   => 'required|string|max:255',
            'latitud'     => 'required|numeric',
            'longitud'    => 'required|numeric',
            'marker'      => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'etiquetas'   => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        // Subida de archivo con "move()" en la carpeta public/markers
        $markerPath = 'markers/default.png'; // Valor por defecto
        if ($request->hasFile('marker')) {
            $file = $request->file('marker');
            $filename = $file->hashName(); 
            $destinationPath = public_path('markers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $markerPath = 'markers/' . $filename;
        }

        try {
            DB::beginTransaction();

            $lugar = Lugar::create([
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion,
                'direccion'   => $request->direccion,
                'latitud'     => $request->latitud,
                'longitud'    => $request->longitud,
                'marker'      => $markerPath,
            ]);

            if ($request->has('etiquetas')) {
                $lugar->etiquetas()->sync($request->etiquetas);
            }

            DB::commit();

            return redirect()->route('admin.lugares.index')
                             ->with('success', 'Lugar creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Opcional: eliminar el archivo subido en caso de error
            return redirect()->route('admin.lugares.index')
                             ->with('error', 'Ocurrió un error al crear el lugar.');
        }
    }

    /**
     * Formulario de edición de un lugar.
     */
    public function edit(Lugar $lugare)
    {
        $etiquetas = Etiqueta::all();
        $etiquetasSeleccionadas = $lugare->etiquetas->pluck('id')->toArray();
        return view('admin.lugares.edit', compact('lugare', 'etiquetas', 'etiquetasSeleccionadas'));
    }

    /**
     * Actualiza un lugar existente (con transacción).
     */
    public function update(Request $request, Lugar $lugare)
    {
        $request->validate([
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'required|string',
            'direccion'   => 'required|string|max:255',
            'latitud'     => 'required|numeric',
            'longitud'    => 'required|numeric',
            'marker'      => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'etiquetas'   => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        $nuevoMarkerPath = null;
        if ($request->hasFile('marker')) {
            if ($lugare->marker && $lugare->marker !== 'markers/default.png') {
                $oldPath = public_path($lugare->marker);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $file = $request->file('marker');
            $filename = $file->hashName();
            $destinationPath = public_path('markers');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $filename);
            $nuevoMarkerPath = 'markers/' . $filename;
        }

        try {
            DB::beginTransaction();

            if ($nuevoMarkerPath) {
                $lugare->marker = $nuevoMarkerPath;
            }
            $lugare->nombre      = $request->nombre;
            $lugare->descripcion = $request->descripcion;
            $lugare->direccion   = $request->direccion;
            $lugare->latitud     = $request->latitud;
            $lugare->longitud    = $request->longitud;
            $lugare->save();

            if ($request->has('etiquetas')) {
                $lugare->etiquetas()->sync($request->etiquetas);
            } else {
                $lugare->etiquetas()->detach();
            }

            DB::commit();

            return redirect()->route('admin.lugares.index')
                             ->with('success', 'Lugar actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Opcional: eliminar el archivo nuevo si falla
            return redirect()->route('admin.lugares.index')
                             ->with('error', 'Ocurrió un error al actualizar el lugar.');
        }
    }

    /**
     * Elimina un lugar y su icono si no es default (con transacción).
     */
    public function destroy(Lugar $lugare)
    {
        try {
            DB::beginTransaction();

            if ($lugare->marker && $lugare->marker !== 'markers/default.png') {
                $oldPath = public_path($lugare->marker);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $lugare->delete();

            DB::commit();

            return redirect()->route('admin.lugares.index')
                             ->with('success', 'Lugar eliminado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.lugares.index')
                             ->with('error', 'Ocurrió un error al eliminar el lugar.');
        }
    }

    /**
     * Devuelve lugares en JSON (filtrado por etiqueta).
     * GET /lugares/json?etiqueta=ID_ETIQUETA
     */
    public function json(Request $request)
    {
        $query = Lugar::with('etiquetas');

        if ($request->has('etiqueta') && !empty($request->etiqueta)) {
            $etiquetaId = $request->etiqueta;
            $query->whereHas('etiquetas', function($q) use ($etiquetaId) {
                $q->where('etiqueta_id', $etiquetaId);
            });
        }

        $lugares = $query->get();
        return response()->json($lugares);
    }

    /**
     * Método API: Buscar lugares por término (nombre o descripción).
     */
    public function buscar(Request $request)
    {
        $query = $request->input('q');
        if (empty($query)) {
            return response()->json([]);
        }

        $lugares = Lugar::where('nombre', 'LIKE', "%{$query}%")
                        ->orWhere('descripcion', 'LIKE', "%{$query}%")
                        ->get();
        return response()->json($lugares);
    }

    /**
     * Muestra la vista del mapa.
     */
    public function map()
    {
        $etiquetas = Etiqueta::all();
        return view('admin.lugares.map', compact('etiquetas'));
    }
}
