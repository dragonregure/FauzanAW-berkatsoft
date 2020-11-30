<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckLevel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index() {
        $data = [
            'pageTitle' => 'Dashboard'
        ];
        return view('admin/dashboard', $data);
    }
}
