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
                <label for="cargo">Cargo</label>
                <select name="cargo" id="cargo" class="form-control" required>
                    <option value="Profesor">Profesor</option>
                    <option value="Asistente">Asistente</option>
                    <option value="Tecnico">Tecnico</option>
                    <option value="Administrativo">Administrativo</option>
                    <option value="Auxiliar">Auxiliar</option>
                    <option value="Aprendiz">Aprendiz</option>
                    <option value="Rectora">Rectora</option>
                    <option value="Sub Rectora">Sub Rectora</option>
                </select>
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
                <label>Rol</label>
                <select name="role" class="form-control" required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-info">Registrar Usuario</button>
        </form>
    </div>
</div>
@stop

@section('js')
    <script>
        // Inicializa Select2 si lo deseas
        $('select[name="role"]').select2();
    </script>
@stop