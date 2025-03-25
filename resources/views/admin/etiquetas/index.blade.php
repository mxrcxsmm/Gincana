@extends('layouts.app')

@section('content')
<h1>Etiquetas</h1>
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.etiquetas.create') }}" class="btn btn-primary mb-3">Crear Etiqueta</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Color</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($etiquetas as $etiqueta)
        <tr>
            <td>{{ $etiqueta->nombre }}</td>
            <td><span style="background-color: {{ $etiqueta->color }}; color: #fff; padding:5px;">{{ $etiqueta->color }}</span></td>
            <td>
                <a href="{{ route('admin.etiquetas.edit', $etiqueta->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('admin.etiquetas.destroy', $etiqueta->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Seguro que deseas eliminar esta etiqueta?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
