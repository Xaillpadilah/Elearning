<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    
    public function index()
    {
        return view('guru.nilai.index');
    }
}