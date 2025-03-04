@extends('adminlte::page')

@section('title', 'Administrar Roles y Permisos')

@section('content_header')
    <h1>Roles y Permisos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <!-- Changed route for creating a new role -->
            <a href="{{ route('roles.create') }}" class="btn btn-info">Nuevo Rol</a>
        </div>
        <div class="card-body">
            <table id="roles-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach($role->permissions->pluck('name')->toArray() as $perm)
                                <span class="badge badge-info" style="margin-right:4px;">{{ $perm }}</span>
                            @endforeach
                        </td>
                        <td>
                            <!-- Replace text button with edit icon -->
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <!-- Replace text button with delete icon -->
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Deseas eliminar este rol?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    @if(session('success'))
        <script>
            Swal.fire({
                title: 'Éxito',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#roles-table').DataTable();
        });
    </script>
@stop
