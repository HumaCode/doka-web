<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display the monthly report index page.
     */
    public function bulanan()
    {
        return view('pages.laporan.bulanan');
    }
}
