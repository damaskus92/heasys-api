<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diagnose\StoreDiagnoseRequest;
use App\Http\Resources\DiagnoseResource;
use App\Models\Diagnose;
use Illuminate\Http\Request;

class DiagnoseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DiagnoseResource::collection(Diagnose::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiagnoseRequest $request)
    {
        $diagnose = Diagnose::create($request->validated());

        return response()->json(new DiagnoseResource($diagnose), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
