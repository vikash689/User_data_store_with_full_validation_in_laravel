<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showForm()
    {
        $roles = Role::all();
        return view('welcome', compact('roles'));
    }
}
