@extends('adminlte::page')

@section('title', 'Solicitudes de Documentos')

@section('content_header')
    <h1>Solicitudes de Documentos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('document-requests.create') }}" class="btn btn-primary">Nueva Solicitud</a>
        </div>
        <div class="card-body">
            <table id="requestsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Documento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->document->name }}</td>
                            <td>
                              <span class="badge 
                            @if($request->status == 'abierto') badge-info 
                            @elseif($request->status == 'en proceso') badge-warning 
                            @else badge-success 
                            @endif">{{ $request->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('document-requests.edit', $request) }}" class="btn btn-sm btn-info">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $requests->links() }}
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#requestsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@stop