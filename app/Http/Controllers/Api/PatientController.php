<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\StorePatientRequest;
use App\Http\Resources\PatientResource;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        protected PatientService $service
    ) {}

    /**
     * @OA\Get(
     *     path="/api/patients",
     *     summary="List all patients",
     *     description="Fetch a list of all patients",
     *     tags={"Patient"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PatientResource")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $patients = $this->service->all();

        return response()->json(PatientResource::collection($patients), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/patients",
     *     summary="Create new patient",
     *     description="Create new patient",
     *     tags={"Patient"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StorePatientRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful",
     *         @OA\JsonContent(ref="#/components/schemas/PatientResource")
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
    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = $this->service->create($request->validated());

        return response()->json(new PatientResource($patient), 201);
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
