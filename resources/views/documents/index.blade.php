@extends('adminlte::page')

@section('title', 'Documentos')

@section('content_header')
    <h1>Documentos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('documents.create') }}" class="btn btn-primary">Nuevo Documento</a>
        </div>
        <div class="card-body">
            <table id="documents-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Documento</th>
                        <th>Descripción del Documento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->description }}</td>
                            <td>
                                <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-info">Editar</a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $documents->links() }}
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#documents-table').DataTable();
        });
    </script>
@stop