<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function index()
    {
        // Ambil hasil dari TopsisController dan TopsisMinatController
        $topsisController = new TopsisJenjangController();
        $bestAlternatives = $topsisController->getBestAlternatives();

        $topsisMinatController = new TopsisMinatController();
        $bestSubAlternatives = $topsisMinatController->getBestSubAlternatives();

        // Kirim data ke view
        return view('rekomendasi.index', compact('bestAlternatives', 'bestSubAlternatives'));
    }

    public function cetakPdf()
    {
        // Ambil hasil dari TopsisController dan TopsisMinatController
        $topsisController = new TopsisJenjangController();
        $bestAlternatives = $topsisController->getBestAlternatives();

        $topsisMinatController = new TopsisMinatController();
        $bestSubAlternatives = $topsisMinatController->getBestSubAlternatives();

        // Load view rekomendasi.index sebagai PDF
        $pdf = PDF::loadView('rekomendasi.pdf', compact('bestAlternatives', 'bestSubAlternatives'));
        return $pdf->download('hasil_rekomendasi.pdf');
    }
}
