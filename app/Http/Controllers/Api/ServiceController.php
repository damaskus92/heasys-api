<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Services\TreatmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        protected TreatmentService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/services",
     *     summary="List all services",
     *     description="Fetch a list of all services",
     *     tags={"Service"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ServiceResource")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $services = $this->service->all();

        return response()->json(ServiceResource::collection($services), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/services",
     *     summary="Create new service",
     *     description="Create new service",
     *     tags={"Service"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreServiceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/ServiceResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreServiceRequest $request): JsonResponse
    {
        $service = $this->service->create($request->validated());

        return response()->json(new ServiceResource($service), 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
