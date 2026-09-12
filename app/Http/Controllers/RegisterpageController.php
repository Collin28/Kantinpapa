<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class RegisterpageController extends Controller
{
    public function index()
    {
         return view('users.auth.Register');
    }
}

?>