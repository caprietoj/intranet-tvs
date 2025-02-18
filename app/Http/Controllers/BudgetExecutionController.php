<?php

namespace App\Http\Controllers;

use App\Models\BudgetExecution;
use Illuminate\Http\Request;

class BudgetExecutionController extends Controller
{
    public function index()
    {
        $budgets = BudgetExecution::all();
        $chartData = [
            'labels' => $budgets->pluck('department'),
            'execution' => $budgets->pluck('execution_percentage'),
            'budget' => $budgets->pluck('budget_amount'),
            'executed' => $budgets->pluck('executed_amount'),
        ];
        
        return view('contabilidad.budget.index', compact('budgets', 'chartData'));
    }

    public function create()
    {
        $departments = BudgetExecution::getDepartmentOptions();
        return view('contabilidad.budget.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department' => 'required|string',
            'budget_amount' => 'required|numeric|min:0',
            'executed_amount' => 'required|numeric|min:0',
        ]);

        BudgetExecution::create($validated);

        return redirect()->route('budget.index')
            ->with('success', 'Presupuesto registrado exitosamente.');
    }
}
