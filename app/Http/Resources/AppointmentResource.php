<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *   title="Appointment Resource",
 *   type="object",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="status", type="integer", example=1, description="1 = process, 0 = success"),
 *   @OA\Property(property="patient", ref="#/components/schemas/PatientResource"),
 *   @OA\Property(property="diagnose", ref="#/components/schemas/DiagnoseResource"),
 *   @OA\Property(property="checkups", type="array",
 *       @OA\Items(ref="#/components/schemas/CheckupProgressResource")
 *   )
 * )
 */
class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'diagnose' => new DiagnoseResource($this->whenLoaded('diagnose')),
            'checkups' => CheckupProgressResource::collection($this->whenLoaded('checkups')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
