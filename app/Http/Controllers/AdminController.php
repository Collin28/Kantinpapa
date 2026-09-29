<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function order() {
        return view('admin.order');
    }

    public function menu() {
        return view('admin.menu');
    }

    public function user() {
        return view('admin.user');
    }
}
