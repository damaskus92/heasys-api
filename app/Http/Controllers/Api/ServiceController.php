<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Services\TreatmentService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        protected TreatmentService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = $this->service->all();

        return response()->json(ServiceResource::collection($services), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $service = $this->service->create($request->validated());

        return response()->json(new ServiceResource($service), 201);
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
