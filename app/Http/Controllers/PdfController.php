<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadPdf()
    {
        $data = ['title' => 'Welcome to Laravel PDF Generator'];
        $pdf = Pdf::loadView('pdf_view', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('document.pdf');
    }
}
