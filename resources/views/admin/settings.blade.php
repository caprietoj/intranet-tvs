@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <h1>Mi Perfil</h1>
@stop

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name">Nombre</label>
                <input id="name" type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ auth()->user()->email }}">
            </div>
            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Dejar en blanco para mantener la actual">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirmar nueva contraseña">
            </div>
            <button type="submit" class="btn btn-info">Guardar Cambios</button>
        </form>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Éxito',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@stop