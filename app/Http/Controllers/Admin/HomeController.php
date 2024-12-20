<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poliza;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
       

        return view('admin.dashboard');
    }
}