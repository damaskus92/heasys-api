<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diagnose\StoreDiagnoseRequest;
use App\Http\Resources\DiagnoseResource;
use App\Services\DiagnoseService;
use Illuminate\Http\Request;

class DiagnoseController extends Controller
{
    public function __construct(
        protected DiagnoseService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diagnoses = $this->service->all();

        return response()->json(DiagnoseResource::collection($diagnoses), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiagnoseRequest $request)
    {
        $patient = $this->service->create($request->validated());

        return response()->json(new DiagnoseResource($patient), 201);
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
