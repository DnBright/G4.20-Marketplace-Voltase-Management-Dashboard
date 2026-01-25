<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MateriController extends Controller
{
    /**
     * Display the course material page.
     */
    public function index()
    {
        return view('materi.index');
    }
}
