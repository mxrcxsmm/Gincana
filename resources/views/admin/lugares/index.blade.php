@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Lugares</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.lugares.create') }}" class="btn btn-primary mb-3">Crear Lugar</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Etiquetas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($lugares as $lugar)
                <tr>
                    <td>{{ $lugar->nombre }}</td>
                    <td>{{ $lugar->direccion }}</td>
                    <td>
                        @foreach($lugar->etiquetas as $etiqueta)
                            <span class="badge" style="background-color: {{ $etiqueta->color }}; color: #fff;">
                                {{ $etiqueta->nombre }}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('admin.lugares.edit', $lugar->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        
                        <form action="{{ route('admin.lugares.destroy', $lugar->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" 
                                    onclick="return confirm('¿Estás seguro de eliminar este lugar?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
