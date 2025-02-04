<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // ...existing code...
        return view('admin.settings');
    }
}
