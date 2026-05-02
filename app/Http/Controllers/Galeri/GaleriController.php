<?php

namespace App\Http\Controllers\Galeri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.galery.index');
    }
}
