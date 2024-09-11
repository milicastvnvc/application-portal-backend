<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Call;

class CallController extends Controller
{
    public function getAll()
    {
        $calls = Call::all();
        return response()->json([
            'success' => true,
            'data' => $calls
        ]);
    }
}
