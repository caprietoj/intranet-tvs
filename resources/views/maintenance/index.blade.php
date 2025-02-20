@extends('adminlte::page')

@section('title', 'Solicitudes de Mantenimiento')

@section('content_header')
    <h1 class="text-primary">Solicitudes de Mantenimiento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Nueva Solicitud
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Ubicación</th>
                            <th>Descripción</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Solicitante</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $request->request_type)) }}</td>
                            <td>{{ $request->location }}</td>
                            <td>{{ Str::limit($request->description, 50) }}</td>
                            <td>
                                <span class="badge badge-{{ $request->priority == 'high' ? 'danger' : ($request->priority == 'medium' ? 'warning' : 'success') }}">
                                    {{ ucfirst($request->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'in_progress' ? 'info' : ($request->status == 'completed' ? 'success' : 'danger')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </td>
                            <td>{{ $request->user->name }}</td>
                            <td>
                                @if(auth()->user()->hasRole('admin'))
                                <form action="{{ route('maintenance.status', $request) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                                        <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Rechazado</option>
                                    </select>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        :root {
            --primary: #364E76;
        }
        
        .text-primary {
            color: var(--primary) !important;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(54, 78, 118, 0.125);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #2a3d5d;
            border-color: #2a3d5d;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }

        .pagination {
            justify-content: center;
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .page-link {
            color: var(--primary);
        }

        .page-link:hover {
            color: #2a3d5d;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 14px;
            }
            
            .btn {
                font-size: 14px;
                padding: 0.375rem 0.75rem;
            }
        }
    </style>
@stop
