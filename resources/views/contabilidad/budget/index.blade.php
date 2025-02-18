@extends('adminlte::page')

@section('title', 'Ejecución Presupuestal')

@section('content_header')
    <h1>Ejecución Presupuestal</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <canvas id="budgetChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Departamento</th>
                            <th>Presupuesto</th>
                            <th>Ejecutado</th>
                            <th>% Ejecución</th>
                            <th>Análisis</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <td>{{ $budget->department }}</td>
                            <td>${{ number_format($budget->budget_amount, 2, ',', '.') }}</td>
                            <td>${{ number_format($budget->executed_amount, 2, ',', '.') }}</td>
                            <td>{{ number_format($budget->execution_percentage, 2) }}%</td>
                            <td>{{ $budget->analysis }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('budgetChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: '% Ejecución',
            data: @json($chartData['execution']),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
@stop
