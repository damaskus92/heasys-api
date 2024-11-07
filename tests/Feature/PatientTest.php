<?php

namespace Tests\Feature;

use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_patients(): void
    {
        $patients = [
            ['name' => 'Budi'],
            ['name' => 'Indah'],
            ['name' => 'Siska'],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }

        $response = $this->getJson(uri: '/api/patients');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_patient()
    {
        $patient = [
            'name' => 'Budi',
        ];

        $response = $this->postJson(uri: '/api/patients', data: $patient);

        $response->assertStatus(201)
            ->assertJsonFragment($patient);

        $this->assertDatabaseHas('patients', $patient);
    }
}
