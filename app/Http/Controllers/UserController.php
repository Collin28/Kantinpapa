<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
       
    }

    public function orderHistory() {
        return view('users.orderHistory');
    }

    public function cart() {
        return view('users.cart');
    }

    public function payConfirm() {
        return view('users.payConfirm');
    }
}
