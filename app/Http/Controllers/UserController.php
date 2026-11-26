<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        return view('users.home');
    }

    public function orderHistory()
    {
        return view('users.order-history');
    }

    public function cart()
    {
        return view('users.cart');
    }

    public function payConfirm()
    {
        return view('users.payconfirm');
    }
}
