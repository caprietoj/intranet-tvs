{{-- resources/views/tickets/create.blade.php --}}
@extends('adminlte::page')

@section('title', 'Crear Ticket')

@section('content_header')
    <h1>Crear Ticket</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form id="createTicketForm">
            @csrf
            {{-- Input de usuario (mostrar primero) --}}
            <div class="form-group">
                <label>Usuario</label>
                <input type="text" value="{{ auth()->user()->name }}" class="form-control" readonly>
            </div>
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
            </div>
            {{-- Tipo de requerimiento antes de prioridad --}}
            <div class="form-group">
                <label for="tipo_requerimiento">Tipo de Requerimiento</label>
                <select name="tipo_requerimiento" id="tipo_requerimiento" class="form-control" required>
                    <option value="Hardware">Hardware</option>
                    <option value="Software">Software</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Instalación">Instalación</option>
                    <option value="Conectividad">Conectividad</option>
                </select>
            </div>
            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select name="prioridad" id="prioridad" class="form-control" required>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear Ticket</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#createTicketForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("tickets.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                Swal.fire(
                    'Éxito!',
                    response.message,
                    'success'
                ).then(() => {
                    window.location.href = '{{ route("tickets.index") }}';
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '<br>';
                });
                Swal.fire('Error!', errorMessage, 'error');
            }
        });
    });
</script>
@stop
