@extends('adminlte::page')

@section('title', 'Dashboard Ausentismos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dashboard de Ausentismos</h1>
        </div>
        <div class="col-sm-6">
            <select id="mesSelector" class="form-control float-right" style="width: 200px;">
                <option value="">Todos los meses</option>
                <option value="Enero">Enero</option>
                <option value="Febrero">Febrero</option>
                <option value="Marzo">Marzo</option>
                <option value="Abril">Abril</option>
                <option value="Mayo">Mayo</option>
                <option value="Junio">Junio</option>
                <option value="Julio">Julio</option>
                <option value="Agosto">Agosto</option>
                <option value="Septiembre">Septiembre</option>
                <option value="Octubre">Octubre</option>
                <option value="Noviembre">Noviembre</option>
                <option value="Diciembre">Diciembre</option>
            </select>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 class="totalAusencias">{{ $totalAusencias }}</h3>
                    <p>Total Ausencias</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 class="motivoComun">{{ $motivoComun->motivo_de_ausencia ?? 'N/A' }}</h3>
                    <p>Motivo más común</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 class="dependenciaAfectada">{{ $dependenciaAfectada->dependencia ?? 'N/A' }}</h3>
                    <p>Dependencia más afectada</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ausencias por Motivo</h3>
                </div>
                <div class="card-body">
                    <canvas id="motivosChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ausencias por Dependencia</h3>
                </div>
                <div class="card-body">
                    <canvas id="dependenciasChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Ausentismos</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select id="mesFiltro" class="form-control">
                        <option value="">Todos los meses</option>
                        <option value="Enero">Enero</option>
                        <option value="Febrero">Febrero</option>
                        <option value="Marzo">Marzo</option>
                        <option value="Abril">Abril</option>
                        <option value="Mayo">Mayo</option>
                        <option value="Junio">Junio</option>
                        <option value="Julio">Julio</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Septiembre">Septiembre</option>
                        <option value="Octubre">Octubre</option>
                        <option value="Noviembre">Noviembre</option>
                        <option value="Diciembre">Diciembre</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="dependenciaFiltro" class="form-control">
                        <option value="">Todas las dependencias</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="duracionFiltro" class="form-control">
                        <option value="">Todas las duraciones</option>
                        <option value="corta">3 días o menos</option>
                        <option value="larga">Más de 3 días</option>
                    </select>
                </div>
            </div>
            <table id="ausentismosTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Persona</th>
                        <th>Dependencia</th>
                        <th>Fecha Desde</th>
                        <th>Fecha Hasta</th>
                        <th>Motivo</th>
                        <th>Duración</th>
                        <th>Mes</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Variable para almacenar el mes seleccionado
            var mesSeleccionado = '';
            
            // Función para actualizar el dashboard
            function actualizarDashboard(mes) {
                $.ajax({
                    url: '{{ route("ausentismos.dashboard") }}',
                    data: { mes: mes },
                    type: 'GET',
                    success: function(response) {
                        // Actualizar tarjetas
                        $('.totalAusencias').text(response.totalAusencias);
                        $('.motivoComun').text(response.motivoComun.motivo_de_ausencia || 'N/A');
                        $('.dependenciaAfectada').text(response.dependenciaAfectada.dependencia || 'N/A');

                        // Actualizar gráficos
                        motivosChart.data.labels = response.motivosPorcentaje.map(item => item.motivo_de_ausencia);
                        motivosChart.data.datasets[0].data = response.motivosPorcentaje.map(item => item.total);
                        motivosChart.update();

                        dependenciasChart.data.labels = response.dependenciasPorcentaje.map(item => item.dependencia);
                        dependenciasChart.data.datasets[0].data = response.dependenciasPorcentaje.map(item => item.total);
                        dependenciasChart.update();

                        // Actualizar tabla
                        table.ajax.reload();
                    }
                });
            }

            // Evento change del selector de mes
            $('#mesSelector').change(function() {
                mesSeleccionado = $(this).val();
                actualizarDashboard(mesSeleccionado);
            });

            // Modificar la configuración de DataTables para incluir el mes en los filtros
            var table = $('#ausentismosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("ausentismos.data") }}',
                    type: 'GET',
                    data: function(d) {
                        d.mes = mesSeleccionado;
                        d.dependencia = $('#dependenciaFiltro').val();
                        d.duracion = $('#duracionFiltro').val();
                    }
                },
                columns: [
                    {data: 'persona', name: 'persona'},
                    {data: 'dependencia', name: 'dependencia'},
                    {data: 'fecha_ausencia_desde', name: 'fecha_ausencia_desde'},
                    {data: 'fecha_hasta', name: 'fecha_hasta'},
                    {data: 'motivo_de_ausencia', name: 'motivo_de_ausencia'},
                    {data: 'duracion_ausencia', name: 'duracion_ausencia'},
                    {data: 'mes', name: 'mes'}
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                },
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Actualizar tabla cuando cambian los filtros
            $('#mesFiltro, #dependenciaFiltro, #duracionFiltro').change(function() {
                table.draw();
            });

            // Cargar lista de dependencias única para el filtro
            $.ajax({
                url: '{{ route("ausentismos.data") }}',
                type: 'GET',
                success: function(data) {
                    var dependencias = [];
                    data.data.forEach(function(item) {
                        if (!dependencias.includes(item.dependencia)) {
                            dependencias.push(item.dependencia);
                            $('#dependenciaFiltro').append(
                                $('<option>', {
                                    value: item.dependencia,
                                    text: item.dependencia
                                })
                            );
                        }
                    });
                }
            });

            // Gráficos
            var ctx1 = document.getElementById('motivosChart').getContext('2d');
            var motivosChart = new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($motivosPorcentaje->pluck('motivo_de_ausencia')) !!},
                    datasets: [{
                        data: {!! json_encode($motivosPorcentaje->pluck('total')) !!},
                        backgroundColor: [
                            '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'
                        ]
                    }]
                }
            });

            var ctx2 = document.getElementById('dependenciasChart').getContext('2d');
            var dependenciasChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($dependenciasPorcentaje->pluck('dependencia')) !!},
                    datasets: [{
                        label: 'Ausencias por Dependencia',
                        data: {!! json_encode($dependenciasPorcentaje->pluck('total')) !!},
                        backgroundColor: '#00a65a'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@stop
