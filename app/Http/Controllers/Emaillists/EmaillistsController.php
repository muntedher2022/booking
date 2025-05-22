<?php

namespace App\Http\Controllers\Emaillists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmaillistsController extends Controller
{
    public function index()
    {
        return view('content.Emaillists.index');
    }
}
