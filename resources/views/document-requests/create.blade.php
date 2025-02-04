@extends('adminlte::page')

@section('title', 'Nueva Solicitud')

@section('content_header')
    <h1>Nueva Solicitud de Documento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('document-requests.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                </div>
                <div class="form-group">
                    <label>Documento</label>
                    <select name="document_id" class="form-control" required>
                        @foreach($documents as $document)
                            <option value="{{ $document->id }}">{{ $document->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop