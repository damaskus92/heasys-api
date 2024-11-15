<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Appointment",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="patient_id", type="integer", example=1),
 *   @OA\Property(property="diagnose_id", type="integer", example=1),
 *   @OA\Property(property="status", type="integer", example=0, description="1 = process, 0 = success"),
 * )
 */
class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'diagnose_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'patient_id',
        'diagnose_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
        ];
    }

    /**
     * Get the patient that owns the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the diagnose associated with the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diagnose()
    {
        return $this->belongsTo(Diagnose::class);
    }

    /**
     * Get the checkup progresses associated with the appointment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkups()
    {
        return $this->hasMany(CheckupProgress::class);
    }
}
