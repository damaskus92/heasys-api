<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="Service",
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="name", type="string", example="String"),
 * )
 */
class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the checkup progresses associated with the service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkups()
    {
        return $this->hasMany(CheckupProgress::class);
    }
}
