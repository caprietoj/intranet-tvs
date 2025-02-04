@extends('adminlte::page')

@section('title', 'Administrar Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.create') }}" class="btn btn-success">Nuevo Usuario</a>
        </div>
        <div class="card-body">
            <table id="users-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles->pluck('name')->toArray() as $role)
                                <span class="badge badge-info" style="margin-right:4px;">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Deseas eliminar este usuario?')">
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
            $('#users-table').DataTable();
        });
    </script>
@stop
