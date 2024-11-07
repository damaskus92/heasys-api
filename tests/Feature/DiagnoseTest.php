<?php

namespace Tests\Feature;

use App\Models\Diagnose;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DiagnoseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_diagnoses(): void
    {
        $diagnoses = [
            ['name' => 'Ringan'],
            ['name' => 'Berat'],
            ['name' => 'Kritis'],
        ];

        foreach ($diagnoses as $diagnose) {
            Diagnose::create($diagnose);
        }

        $response = $this->getJson(uri: '/api/diagnoses');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_diagnose()
    {
        $diagnose = [
            'name' => 'Ringan',
        ];

        $response = $this->postJson(uri: '/api/diagnoses', data: $diagnose);

        $response->assertStatus(201)
            ->assertJsonFragment($diagnose);

        $this->assertDatabaseHas('diagnoses', $diagnose);
    }
}
