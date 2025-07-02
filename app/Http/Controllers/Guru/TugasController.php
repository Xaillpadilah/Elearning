<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        return view('guru.tugas.index');
    }
}
