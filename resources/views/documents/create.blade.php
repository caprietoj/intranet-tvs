@extends('adminlte::page')

@section('title', 'Crear Documento')

@section('content_header')
    <h1>Crear Documento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('documents.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre del Documento</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Descripción del Documento</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop