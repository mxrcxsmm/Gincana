@extends('layouts.app')

@section('content')
<h1>Puntos de Control</h1>
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.puntos-control.create') }}" class="btn btn-primary mb-3">Crear Punto de Control</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Lugar</th>
            <th>Descripción</th>
            <th>Pista</th>
            <th>Prueba</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($puntos as $p)
        <tr>
            <td>{{ $p->lugar->nombre }}</td>
            <td>{{ $p->descripcion }}</td>
            <td>{{ $p->pista }}</td>
            <td>{{ $p->prueba }}</td>
            <td>
                <a href="{{ route('admin.puntos-control.edit', $p->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('admin.puntos-control.destroy', $p->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Eliminar este punto de control?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
