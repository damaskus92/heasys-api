<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diagnose\StoreDiagnoseRequest;
use App\Http\Resources\DiagnoseResource;
use App\Services\DiagnoseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiagnoseController extends Controller
{
    public function __construct(
        protected DiagnoseService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/diagnoses",
     *     summary="List all diagnoses",
     *     description="Fetch a list of all diagnoses",
     *     tags={"Diagnose"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/DiagnoseResource")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $diagnoses = $this->service->all();

        return response()->json(DiagnoseResource::collection($diagnoses), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/diagnoses",
     *     summary="Create new diagnose",
     *     description="Create new diagnose",
     *     tags={"Diagnose"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreDiagnoseRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/DiagnoseResource")
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
    public function store(StoreDiagnoseRequest $request): JsonResponse
    {
        $diagnose = $this->service->create($request->validated());

        return response()->json(new DiagnoseResource($diagnose), 201);
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
