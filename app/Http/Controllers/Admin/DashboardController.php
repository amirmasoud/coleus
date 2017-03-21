<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Main dashboard view page.
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
