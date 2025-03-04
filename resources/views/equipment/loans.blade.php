@extends('adminlte::page')

@section('title', 'Préstamos de Equipos')

@section('content_header')
    <h1 class="text-primary">Historial de Préstamos</h1>
@stop

@section('content')
<div class="card custom-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="loansTable">
                <thead class="thead-primary">
                    <tr>
                        <th>ID</th>
                        <th>Docente</th>
                        <th>Sección</th>
                        <th>Salón</th> <!-- Changed from "Grado/Curso" to "Salón" -->
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
                            <td>{{ $loan->equipment->type === 'laptop' ? 'Portátil' : 'iPad' }}</td>
                            <td>{{ $loan->units_requested }}</td>
                            <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($loan->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($loan->end_time)->format('H:i') }}</td>
                            <td>
                                <span class="badge badge-{{ $loan->status_color }}">
                                    {{ $loan->status_label }}
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
    :root {
        --primary: #364E76;
        --accent: #ED3236;
        --success: #28a745;
        --warning: #ffc107;
        --info: #17a2b8;
    }

    /* Header Styles */
    .text-primary {
        color: var(--primary) !important;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    /* Card Styles */
    .custom-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        background-color: #ffffff;
    }

    /* Table Styles */
    .table {
        margin-bottom: 0;
    }

    .thead-primary {
        background-color: var(--primary);
        color: white;
    }

    .thead-primary th {
        border: none;
        padding: 1rem;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .table td {
        vertical-align: middle;
        padding: 0.75rem 1rem;
        color: #495057;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(54, 78, 118, 0.05);
        transition: background-color 0.3s ease;
    }

    /* Badge Styles */
    .badge {
        padding: 0.5em 1em;
        font-size: 0.85em;
        font-weight: 500;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-pending {
        background-color: var(--warning);
        color: #000;
    }

    .badge-active {
        background-color: var(--success);
        color: white;
    }

    .badge-completed {
        background-color: var(--info);
        color: white;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px 8px;
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(54, 78, 118, 0.25);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--primary) !important;
        color: white !important;
        border: 1px solid var(--primary) !important;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #2a3d5d !important;
        color: white !important;
        border: 1px solid #2a3d5d !important;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }
        
        .badge {
            display: inline-block;
            margin: 2px 0;
        }
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    $('#loansTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "order": [[6, "desc"], [7, "desc"]],
        "pageLength": 10,
        "responsive": true
    });
});
</script>
@stop
