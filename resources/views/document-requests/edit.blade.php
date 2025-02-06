@extends('adminlte::page')

@section('title', 'Editar Solicitud')

@section('content_header')
    <h1>Editar Solicitud de Documento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Added enctype for file upload --}}
            <form action="{{ route('document-requests.update', $documentRequest) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" class="form-control" value="{{ $documentRequest->user->name }}" disabled>
                </div>
                <div class="form-group">
                    <label>Documento</label>
                    <select name="document_id" class="form-control" required>
                        @foreach($documents as $document)
                            <option value="{{ $document->id }}" {{ $document->id == $documentRequest->document_id ? 'selected' : '' }}>
                                {{ $document->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $documentRequest->description }}</textarea>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select name="status" class="form-control" required>
                        <option value="abierto" {{ $documentRequest->status == 'abierto' ? 'selected' : '' }}>Abierto</option>
                        <option value="en proceso" {{ $documentRequest->status == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="cerrado" {{ $documentRequest->status == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>
                {{-- New file input for certificate --}}
                <div class="form-group">
                    <label>Adjuntar Certificado (PDF, JPG, DOCX)</label>
                    <input type="file" name="certificate" class="form-control" accept=".pdf,.jpg,.docx">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
@stop