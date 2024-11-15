<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Schema(
 *   title="Store Appointment Request",
 *   type="object",
 *   @OA\Property(property="patient_id", type="integer", example=1, description="ID of the patient"),
 *   @OA\Property(property="diagnose_id", type="integer", example=1, description="ID of the diagnose"),
 *   required={"patient_id", "diagnose_id"}
 * )
 */
class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => ['required', 'exists:patients,id'],
            'diagnose_id' => ['required', 'exists:diagnoses,id'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'error' => $validator->errors()
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
