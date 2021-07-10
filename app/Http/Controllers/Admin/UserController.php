<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Display user data
    public function index()
    {
        $users = User::where('is_admin', '!=', true)->latest()->paginate(5);

        return view('admin.user.index', compact('users'));
    }
}
