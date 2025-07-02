<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        return view('guru.pengumuman.index');
    }
}