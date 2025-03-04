@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <!-- Se agrega el campo de cargo para permitir su edición -->
            <div class="form-group">
                <label for="cargo">Cargo</label>
                <select name="cargo" id="cargo" class="form-control" required>
                    <option value="Profesor" {{ $user->cargo == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                    <option value="Asistente" {{ $user->cargo == 'Asistente' ? 'selected' : '' }}>Asistente</option>
                    <option value="Tecnico" {{ $user->cargo == 'Tecnico' ? 'selected' : '' }}>Tecnico</option>
                    <option value="Administrativo" {{ $user->cargo == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                    <option value="Auxiliar" {{ $user->cargo == 'Auxiliar' ? 'selected' : '' }}>Auxiliar</option>
                    <option value="Aprendiz" {{ $user->cargo == 'Aprendiz' ? 'selected' : '' }}>Aprendiz</option>
                    <option value="Rectora" {{ $user->cargo == 'Rectora' ? 'selected' : '' }}>Rectora</option>
                    <option value="Sub Rectora" {{ $user->cargo == 'Sub Rectora' ? 'selected' : '' }}>Sub Rectora</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label>Contraseña (déjalo en blanco para mantener la actual)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <div class="form-group">
                <label>Rol</label>
                <select name="role" class="form-control" required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ in_array($role, $userRoles) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-info">Actualizar Usuario</button>
        </form>
    </div>
</div>
@stop

@section('js')
    <script>
        $('select[name="role"]').select2();
    </script>
@stop