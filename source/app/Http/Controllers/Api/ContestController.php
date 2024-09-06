<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contest;

class ContestController extends Controller
{
    public function getAll()
    {
        $contests = Contest::all();
        return response()->json([
            'success' => true,
            'data' => $contests
        ]);
    }
}
