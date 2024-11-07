<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_services(): void
    {
        $services = [
            ['name' => 'Obat'],
            ['name' => 'Rawat Inap'],
            ['name' => 'ICU'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $response = $this->getJson(uri: '/api/services');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_can_create_service()
    {
        $service = [
            'name' => 'Obat',
        ];

        $response = $this->postJson(uri: '/api/services', data: $service);

        $response->assertStatus(201)
            ->assertJsonFragment($service);

        $this->assertDatabaseHas('services', $service);
    }
}
