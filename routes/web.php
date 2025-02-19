<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

// Enfermería
use App\Http\Controllers\KpiController;
use App\Http\Controllers\ThresholdController;

// Compras
use App\Http\Controllers\KpiComprasController;
use App\Http\Controllers\ThresholdComprasController;

// Recursos Humanos
use App\Http\Controllers\RecursosHumanosKpiController;
use App\Http\Controllers\RecursosHumanosThresholdController;

// Sistemas
use App\Http\Controllers\SistemasKpiController;
use App\Http\Controllers\SistemasThresholdController;

// contabilidad
use App\Http\Controllers\ContabilidadKpiController;
use App\Http\Controllers\ContabilidadThresholdController;
use App\Http\Controllers\BudgetExecutionController; // Add this line

// Documentos
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\UserController;

// Reportes
use App\Http\Controllers\KPIReportController;
use App\Http\Controllers\AttendanceController; // Agregar esta línea

use App\Http\Controllers\EventController;  // Agregar esta línea
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AnnouncementController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('enfermeria')->group(function () {
        // Rutas para KPIs de Enfermería
        Route::get('kpis/create', [KpiController::class, 'createEnfermeria'])->name('kpis.enfermeria.create');
        Route::post('kpis', [KpiController::class, 'storeEnfermeria'])->name('kpis.enfermeria.store');
        Route::get('kpis', [KpiController::class, 'indexEnfermeria'])->name('kpis.enfermeria.index');
        Route::get('kpis/{id}/edit', [KpiController::class, 'editEnfermeria'])->name('kpis.enfermeria.edit');
        Route::put('kpis/{id}', [KpiController::class, 'updateEnfermeria'])->name('kpis.enfermeria.update');
        Route::get('kpis/{id}', [KpiController::class, 'showEnfermeria'])->name('kpis.enfermeria.show');
        Route::delete('kpis/{id}', [KpiController::class, 'destroyEnfermeria'])->name('kpis.enfermeria.destroy');
    
        // Rutas para la Configuración del Umbral en Enfermería
        Route::get('umbral', [ThresholdController::class, 'indexEnfermeria'])->name('umbral.enfermeria.index');
        Route::post('umbral', [ThresholdController::class, 'updateEnfermeria'])->name('umbral.enfermeria.update');
        
        // (Opcional) Ruta para visualizar el threshold en modo "show"
        Route::get('umbral/show', [ThresholdController::class, 'showEnfermeria'])->name('umbral.enfermeria.show');
        
        // Nueva ruta para crear umbral en Enfermería
        Route::get('umbral/create', [ThresholdController::class, 'createEnfermeria'])->name('umbral.enfermeria.create');
        
        // Nueva ruta agregada para almacenar el umbral en Enfermería.
        Route::post('umbral/store', [ThresholdController::class, 'storeEnfermeria'])->name('umbral.enfermeria.store');

        // Nueva ruta para editar el umbral en Enfermería.
        Route::get('umbral/edit', [ThresholdController::class, 'editEnfermeria'])->name('umbral.enfermeria.edit');
    });

    Route::prefix('compras')->group(function () {
        // Rutas de KPIs para Compras
        Route::get('kpis', [KpiComprasController::class, 'indexCompras'])->name('kpis.compras.index');
        Route::get('kpis/create', [KpiComprasController::class, 'createCompras'])->name('kpis.compras.create');
        Route::post('kpis', [KpiComprasController::class, 'storeCompras'])->name('kpis.compras.store');
        Route::get('kpis/{id}', [KpiComprasController::class, 'showCompras'])->name('kpis.compras.show');
        Route::get('kpis/{id}/edit', [KpiComprasController::class, 'editCompras'])->name('kpis.compras.edit');
        Route::put('kpis/{id}', [KpiComprasController::class, 'updateCompras'])->name('kpis.compras.update');
        Route::delete('kpis/{id}', [KpiComprasController::class, 'destroyCompras'])->name('kpis.compras.destroy');

        // Rutas de Threshold para Compras
        Route::get('umbral/create', [ThresholdComprasController::class, 'createCompras'])->name('umbral.compras.create');
        Route::post('umbral', [ThresholdComprasController::class, 'storeCompras'])->name('umbral.compras.store');
        Route::get('umbral/edit', [ThresholdComprasController::class, 'editCompras'])->name('umbral.compras.edit');
        Route::put('umbral', [ThresholdComprasController::class, 'updateCompras'])->name('umbral.compras.update');
        Route::get('umbral/show', [ThresholdComprasController::class, 'showCompras'])->name('umbral.compras.show');
        Route::delete('umbral/{id}', [ThresholdComprasController::class, 'destroyCompras'])->name('umbral.compras.destroy');
    });

    Route::prefix('rrhh')->group(function () {
        // Rutas de KPIs para RRHH
        Route::get('kpis', [RecursosHumanosKpiController::class, 'indexRecursosHumanos'])->name('kpis.rrhh.index');
        Route::get('kpis/create', [RecursosHumanosKpiController::class, 'createRecursosHumanos'])->name('kpis.rrhh.create');
        Route::post('kpis', [RecursosHumanosKpiController::class, 'storeRecursosHumanos'])->name('kpis.rrhh.store');
        Route::get('kpis/{id}', [RecursosHumanosKpiController::class, 'showRecursosHumanos'])->name('kpis.rrhh.show');
        Route::get('kpis/{id}/edit', [RecursosHumanosKpiController::class, 'editRecursosHumanos'])->name('kpis.rrhh.edit');
        Route::put('kpis/{id}', [RecursosHumanosKpiController::class, 'updateRecursosHumanos'])->name('kpis.rrhh.update');
        Route::delete('kpis/{id}', [RecursosHumanosKpiController::class, 'destroyRecursosHumanos'])->name('kpis.rrhh.destroy');

        // Rutas de Threshold para RRHH
        Route::get('umbral/create', [RecursosHumanosThresholdController::class, 'createRecursosHumanos'])->name('umbral.rrhh.create');
        Route::post('umbral', [RecursosHumanosThresholdController::class, 'storeRecursosHumanos'])->name('umbral.rrhh.store');
        Route::get('umbral/edit', [RecursosHumanosThresholdController::class, 'editRecursosHumanos'])->name('umbral.rrhh.edit');
        Route::put('umbral', [RecursosHumanosThresholdController::class, 'updateRecursosHumanos'])->name('umbral.rrhh.update');
        Route::get('umbral/show', [RecursosHumanosThresholdController::class, 'showRecursosHumanos'])->name('umbral.rrhh.show');
        Route::delete('umbral/{id}', [RecursosHumanosThresholdController::class, 'destroyRecursosHumanos'])->name('umbral.rrhh.destroy');
    });

    Route::prefix('contabilidad')->group(function () {
        // Budget routes
        Route::get('/budget', [BudgetExecutionController::class, 'index'])->name('budget.index');
        Route::get('/budget/create', [BudgetExecutionController::class, 'create'])->name('budget.create');
        Route::post('/budget', [BudgetExecutionController::class, 'store'])->name('budget.store');

        // Add the consolidated threshold routes here
        Route::prefix('umbral')->name('umbral.contabilidad.')->group(function () {
            Route::get('/', [ContabilidadThresholdController::class, 'indexContabilidad'])->name('index');
            Route::get('/create', [ContabilidadThresholdController::class, 'createContabilidad'])->name('create');
            Route::post('/', [ContabilidadThresholdController::class, 'storeContabilidad'])->name('store');
            Route::get('/show', [ContabilidadThresholdController::class, 'showContabilidad'])->name('show');
            Route::get('/{id}/edit', [ContabilidadThresholdController::class, 'editContabilidad'])->name('edit');
            Route::put('/{id}', [ContabilidadThresholdController::class, 'updateContabilidad'])->name('update');
            Route::delete('/{id}', [ContabilidadThresholdController::class, 'destroyContabilidad'])->name('destroy');
        });
    });

    // Add redirects for old URL patterns
    Route::get('/threshold/contabilidad/create', function() {
        return redirect()->route('umbral.contabilidad.create');
    });
    Route::get('/threshold/contabilidad/show', function() {
        return redirect()->route('umbral.contabilidad.show');
    });

    Route::prefix('sistemas')->group(function () {
        // Rutas de KPIs para Sistemas
        Route::get('kpis', [SistemasKpiController::class, 'indexSistemas'])->name('kpis.sistemas.index');
        Route::get('kpis/create', [SistemasKpiController::class, 'createSistemas'])->name('kpis.sistemas.create');
        Route::post('kpis', [SistemasKpiController::class, 'storeSistemas'])->name('kpis.sistemas.store');
        Route::get('kpis/{id}', [SistemasKpiController::class, 'showSistemas'])->name('kpis.sistemas.show');
        Route::get('kpis/{id}/edit', [SistemasKpiController::class, 'editSistemas'])->name('kpis.sistemas.edit');
        Route::put('kpis/{id}', [SistemasKpiController::class, 'updateSistemas'])->name('kpis.sistemas.update');
        Route::delete('kpis/{id}', [SistemasKpiController::class, 'destroySistemas'])->name('kpis.sistemas.destroy');

        // Rutas de Threshold para Sistemas
        Route::get('umbral/create', [SistemasThresholdController::class, 'createSistemas'])->name('umbral.sistemas.create');
        Route::post('umbral', [SistemasThresholdController::class, 'storeSistemas'])->name('umbral.sistemas.store');
        Route::get('umbral/edit', [SistemasThresholdController::class, 'editSistemas'])->name('umbral.sistemas.edit');
        Route::put('umbral', [SistemasThresholdController::class, 'updateSistemas'])->name('umbral.sistemas.update');
        Route::get('umbral/index', [SistemasThresholdController::class, 'indexSistemas'])->name('umbral.sistemas.index');
        Route::delete('umbral/{id}', [SistemasThresholdController::class, 'destroySistemas'])->name('umbral.sistemas.destroy');
    });

    Route::get('tickets/dashboard', [HomeController::class, 'dashboard'])->name('tickets.dashboard');
    Route::resource('tickets', TicketController::class);

    // ruta para documentos y documentos request
    Route::resource('documents', DocumentController::class);
    Route::resource('document-requests', DocumentRequestController::class);

    // Group admin routes together
    Route::prefix('admin')->group(function () {
        Route::get('/settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('admin.settings');

        Route::resource('roles', App\Http\Controllers\RolesController::class)->names([
            'index'   => 'roles.index',
            'create'  => 'roles.create',
            'store'   => 'roles.store',
            'edit'    => 'roles.edit',
            'update'  => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);

        Route::resource('users', UserController::class);
    });

    // Rutas para el reporte de KPIs
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/kpis/report', [KPIReportController::class, 'index'])->name('kpi.report');
    });

    // Rutas para el controlador de asistencias
    Route::prefix('attendance')->group(function () {
        Route::get('upload', [AttendanceController::class, 'showUploadForm'])->name('attendance.upload');
        Route::post('import', [AttendanceController::class, 'importData'])->name('attendance.import');
        Route::get('dashboard/{mes?}', [AttendanceController::class, 'dashboard'])
            ->name('attendance.dashboard')
            ->where('mes', 'actual|Enero|Febrero|Marzo|Abril|Mayo|Junio|Julio|Agosto|Septiembre|Octubre|Noviembre|Diciembre');
    });

    Route::get('/ausentismos/upload', [App\Http\Controllers\AusentismoController::class, 'showUploadForm'])->name('ausentismos.upload');
    Route::post('/ausentismos/store', [App\Http\Controllers\AusentismoController::class, 'store'])->name('ausentismos.store');
    Route::get('/ausentismos/dashboard', [App\Http\Controllers\AusentismoController::class, 'dashboard'])->name('ausentismos.dashboard');
    Route::get('/ausentismos/data', [App\Http\Controllers\AusentismoController::class, 'getData'])->name('ausentismos.data');

    // Rutas de eventos - deben ir antes de otras rutas que puedan interferir
    Route::get('events/calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('events/dashboard', [EventController::class, 'dashboard'])->name('events.dashboard');
    Route::resource('events', EventController::class);
    Route::post('events/{event}/confirm', [EventController::class, 'confirm'])->name('events.confirm');
    Route::get('events/{event}/confirm/{token}', [EventController::class, 'confirm'])->name('events.confirm');

    // Rutas para el módulo de Reserva de Equipos
    Route::prefix('equipment')->group(function () {
        // Asegúrate de que esta ruta esté antes de otras rutas más genéricas
        Route::post('/reset', [EquipmentController::class, 'resetInventory'])
            ->name('equipment.reset')
            ->middleware('auth', 'can:equipment.manage');
            
        Route::get('/', [EquipmentController::class, 'index'])->name('equipment.index');
        Route::post('/store', [EquipmentController::class, 'store'])->name('equipment.store');
        Route::get('/request', [EquipmentController::class, 'showRequestForm'])->name('equipment.request');
        Route::post('/request', [EquipmentController::class, 'requestLoan'])->name('equipment.request.submit');
        Route::get('/loans', [EquipmentController::class, 'showLoans'])->name('equipment.loans');
        Route::get('/inventory', [EquipmentController::class, 'inventory'])->name('equipment.inventory');
        Route::post('/reset', [EquipmentController::class, 'resetInventory'])->name('equipment.reset')->middleware('can:equipment.manage');
        Route::get('/dashboard', [EquipmentController::class, 'dashboard'])->name('equipment.dashboard');
        Route::get('/loans/data', [EquipmentController::class, 'getLoansData'])->name('equipment.loans.data');
    });

    // Announcement routes
    Route::resource('announcements', AnnouncementController::class);
}); // Close the auth middleware group

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');