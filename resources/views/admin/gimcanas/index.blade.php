@extends('layouts.app')

@section('content')
    <h1>Gimcanas</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.gimcanas.create') }}" class="btn btn-primary mb-3">Crear Gimcana</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Puntos de Control</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($gimcanas as $gimcana)
            <tr>
                <td>{{ $gimcana->nombre }}</td>
                <td>{{ $gimcana->descripcion }}</td>
                <td>
                    @foreach($gimcana->puntosControl as $punto)
                        <span class="badge badge-info">
                            {{ $punto->lugar ? $punto->lugar->nombre : 'Lugar desconocido' }}
                        </span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.gimcanas.edit', $gimcana->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('admin.gimcanas.destroy', $gimcana->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta gimcana?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
