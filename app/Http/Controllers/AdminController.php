<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function orderManagement() {
        return view('admin.orderManagement');
    }

    public function menuManagement() {
        return view('admin.menuManagement');
    }

    public function userManagement() {
        return view('admin.userManagement');
    }
}
