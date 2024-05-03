<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HistoryPostRequest;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::all();

        return response()->json($histories);
    }

    public function store(HistoryPostRequest $request)
    {
        $data = $request->all();

        $history = History::create($data);

        return response()->json($history, 201);
    }
}
