@extends('adminlte::page')

@section('title', 'Registrar Usuario')

@section('content_header')
    <h1>Registrar Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Roles</label>
                <select name="roles[]" class="form-control" multiple required>
                    @foreach($roles as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
        </form>
    </div>
</div>
@stop

@section('js')
    <script>
        // Optional: Initialize Select2 for roles select
        $('select[name="roles[]"]').select2();
    </script>
@stop
