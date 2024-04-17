<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        return view('backend.index');
    }
}