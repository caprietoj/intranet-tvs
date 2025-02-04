@extends('adminlte::page')

@section('title', 'Editar Documento')

@section('content_header')
    <h1>Editar Documento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('documents.update', $document) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="name" class="form-control" value="{{ $document->name }}" required>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control" rows="3">{{ $document->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@stop
