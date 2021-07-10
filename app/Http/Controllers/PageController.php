<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function welcome()
    {
        $page = Page::findOrfail(1); //Welcome Page
        return view('page', compact('page'));
    }

    public function consultaion()
    {
        $page = Page::findOrfail(2); //consultation Page
        return view('page', compact('page'));
    }
}
