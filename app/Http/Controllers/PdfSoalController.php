<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PdfSoalController extends Controller
{
     public function convert(Request $request)
    {
        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:5120'
        ]);

        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('file_pdf')->getPathname());
        $text = $pdf->getText();

        return response()->json(['text' => $text]);
    }
}

