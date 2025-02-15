@extends('adminlte::page')

@section('title', 'Préstamos de Equipos')

@section('content_header')
    <h1>Préstamos de Equipos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="loans-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Docente</th>
                        <th>Sección</th>
                        <th>Grado/Curso</th>
                        <th>Equipo</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                    <tr>
                        <td>{{ $loan->id }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $loan->section)) }}</td>
                        <td>{{ $loan->grade }}</td>
                        <td>
                            {{ $loan->equipment->type === 'laptop' ? 'Portátil' : 'iPad' }}
                        </td>
                        <td>{{ $loan->units_requested }}</td>
                        <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($loan->start_time)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($loan->end_time)->format('H:i') }}
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'active' => 'success',
                                    'completed' => 'info'
                                ];
                                $statusLabels = [
                                    'pending' => 'Pendiente',
                                    'active' => 'Activo',
                                    'completed' => 'Completado'
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$loan->status] }}">
                                {{ $statusLabels[$loan->status] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
.table thead th {
    vertical-align: middle;
}
.badge {
    font-size: 0.9em;
}
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    $('#loans-table').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "order": [[6, "desc"]],
        "pageLength": 10
    });
});
</script>
@stop
