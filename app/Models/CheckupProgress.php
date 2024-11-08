<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   title="Checkup Progress",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="appointment_id", type="integer", example=1),
 *   @OA\Property(property="service_id", type="integer", example=1),
 *   @OA\Property(property="status", type="integer", example=0, description="1 = process, 0 = success"),
 * )
 */
class CheckupProgress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'appointment_id',
        'service_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'appointment_id',
        'service_id',
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
     * Get the appointment that owns the checkup progress.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the service associated with the checkup progress.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
