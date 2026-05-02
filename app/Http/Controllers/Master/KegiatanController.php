<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.kegiatan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kegiatan.create');
    }

    /**
     * Get all pagination data (AJAX)
     * For now, this is just a placeholder since we are using dummy data in JS.
     */
    public function getAllPagination(Request $request)
    {
        // Placeholder for future database implementation
        return response()->json([
            'success' => true,
            'message' => 'Data loaded successfully (Placeholder)',
            'data' => []
        ]);
    }
}
