@extends('adminlte::page')

@section('title', 'Registrar Usuario')

@section('content_header')
    <h1 class="text-primary mb-4">Registrar Usuario</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title text-white mb-0"><i class="fas fa-user-plus mr-2"></i>Nuevo Usuario</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 pr-md-4 border-right">
                            <h4 class="text-primary mb-4">Información Personal</h4>
                            
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-user mr-1"></i>Nombre Completo
                                </label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-briefcase mr-1"></i>Cargo
                                </label>
                                <select name="cargo" class="form-control select2" required>
                                    <option value="">Seleccione un cargo</option>
                                    <option value="Profesor">Profesor</option>
                                    <option value="Asistente">Asistente</option>
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Administrativo">Administrativo</option>
                                    <option value="Auxiliar">Auxiliar</option>
                                    <option value="Aprendiz">Aprendiz</option>
                                    <option value="Rectora">Rectora</option>
                                    <option value="Sub Rectora">Sub Rectora</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-envelope mr-1"></i>Correo Electrónico
                                </label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 pl-md-4">
                            <h4 class="text-primary mb-4">Acceso al Sistema</h4>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-user-shield mr-1"></i>Rol del Usuario
                                </label>
                                <select name="role" class="form-control select2" required>
                                    <option value="">Seleccione un rol</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-lock mr-1"></i>Contraseña
                                </label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-lock mr-1"></i>Confirmar Contraseña
                                </label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times mr-1"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ml-2">
                            <i class="fas fa-save mr-1"></i>Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title text-white mb-0">
                    <i class="fas fa-info-circle mr-2"></i>Información
                </h3>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="fas fa-lightbulb mr-2"></i>Consejos:</h5>
                    <ul class="pl-3 mt-2 mb-0">
                        <li>La contraseña debe tener al menos 8 caracteres</li>
                        <li>El correo debe ser único en el sistema</li>
                        <li>El rol determina los permisos del usuario</li>
                        <li>Todos los campos son obligatorios</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    :root {
        --primary: #364E76;
    }

    .text-primary {
        color: var(--primary) !important;
        font-weight: 600;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .bg-primary {
        background-color: var(--primary) !important;
    }

    .form-control {
        height: calc(2.25rem + 2px);
        border-radius: 4px;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
    }

    .select2-container--default .select2-selection--single {
        height: calc(2.25rem + 2px);
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: calc(2.25rem + 2px);
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem + 2px);
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #2a3d5d;
        border-color: #2a3d5d;
    }

    label {
        color: #495057;
    }

    .invalid-feedback {
        font-size: 80%;
    }

    .border-right {
        border-right-color: rgba(0,0,0,.125) !important;
    }

    .form-group label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .alert-info {
        border-left: 4px solid var(--primary);
    }

    .alert-info ul {
        list-style-type: none;
    }

    .alert-info ul li {
        margin-bottom: 0.5rem;
        position: relative;
        padding-left: 1.5rem;
    }

    .alert-info ul li:before {
        content: "•";
        color: var(--primary);
        font-weight: bold;
        position: absolute;
        left: 0;
    }
</style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#role, #cargo').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
        });
    </script>
@stop