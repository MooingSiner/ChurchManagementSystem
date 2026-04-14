<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 
 
class HomeController extends Controller
{
    public function homepage() {
        return view('homepage');
    }
 
}