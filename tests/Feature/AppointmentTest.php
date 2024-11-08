<?php

namespace Tests\Feature;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected $patients;
    protected $diagnoses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->patients = [
            $this->postJson('/api/patients', ['name' => 'Budi']),
            $this->postJson('/api/patients', ['name' => 'Indah']),
            $this->postJson('/api/patients', ['name' => 'Siska']),
        ];

        $this->diagnoses = [
            $this->postJson('/api/diagnoses', ['name' => 'Ringan']),
            $this->postJson('/api/diagnoses', ['name' => 'Berat']),
            $this->postJson('/api/diagnoses', ['name' => 'Kritis']),
        ];
    }

    public function test_can_list_appointments(): void
    {
        $appointment1 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
        ]);
        $appointment2 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
        ]);
        $appointment3 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
        ]);

        $response = $this->getJson(uri: '/api/appointments');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment(['id' => $appointment1->json('id')])
            ->assertJsonFragment(['id' => $appointment2->json('id')])
            ->assertJsonFragment(['id' => $appointment3->json('id')]);
    }

    public function test_can_create_appointment()
    {
        $appointment1 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
        ]);
        $appointment1->assertStatus(201)
            ->assertJsonFragment([
                'id' => $appointment1->json('id'),
                'status' => StatusEnum::PROCESS,
            ]);

        $appointment2 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
        ]);
        $appointment2->assertStatus(201)
            ->assertJsonFragment([
                'id' => $appointment2->json('id'),
                'status' => StatusEnum::PROCESS,
            ]);

        $appointment3 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
        ]);
        $appointment3->assertStatus(201)
            ->assertJsonFragment([
                'id' => $appointment3->json('id'),
                'status' => StatusEnum::PROCESS,
            ]);

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
            'status' => StatusEnum::PROCESS,
        ]);
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
            'status' => StatusEnum::PROCESS,
        ]);
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
            'status' => StatusEnum::PROCESS,
        ]);
    }

    public function test_can_show_appointment()
    {
        $appointment1 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
        ]);
        $responseAppointment1 = $this->getJson(uri: "/api/appointments/{$appointment1->json('id')}");
        $responseAppointment1->assertStatus(200)
            ->assertJson([
                'id' => $appointment1->json('id'),
                'status' => $appointment1->json('status'),
                'created_at' => Carbon::parse($appointment1->json('created_at'))->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($appointment1->json('updated_at'))->format('Y-m-d H:i:s'),
                'patient' => [
                    'id' => $this->patients[0]->json('id'),
                    'name' => $this->patients[0]->json('name'),
                    'created_at' => Carbon::parse($this->patients[0]->json('created_at'))->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($this->patients[0]->json('updated_at'))->format('Y-m-d H:i:s'),
                ],
                'diagnose' => [
                    'id' => $this->diagnoses[0]->json('id'),
                    'name' => $this->diagnoses[0]->json('name'),
                    'created_at' => Carbon::parse($this->diagnoses[0]->json('created_at'))->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($this->diagnoses[0]->json('updated_at'))->format('Y-m-d H:i:s'),
                ]
            ]);

        $appointment2 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
        ]);
        $responseAppointment2 = $this->getJson(uri: "/api/appointments/{$appointment2->json('id')}");
        $responseAppointment2->assertStatus(200)
            ->assertJson([
                'id' => $appointment2->json('id'),
                'status' => $appointment2->json('status'),
                'created_at' => Carbon::parse($appointment2->json('created_at'))->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($appointment2->json('updated_at'))->format('Y-m-d H:i:s'),
                'patient' => [
                    'id' => $this->patients[1]->json('id'),
                    'name' => $this->patients[1]->json('name'),
                    'created_at' => Carbon::parse($this->patients[1]->json('created_at'))->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($this->patients[1]->json('updated_at'))->format('Y-m-d H:i:s'),
                ],
                'diagnose' => [
                    'id' => $this->diagnoses[1]->json('id'),
                    'name' => $this->diagnoses[1]->json('name'),
                    'created_at' => Carbon::parse($this->diagnoses[1]->json('created_at'))->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($this->diagnoses[1]->json('updated_at'))->format('Y-m-d H:i:s'),
                ]
            ]);


        $appointment3 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
        ]);
        $responseAppointment3 = $this->getJson(uri: "/api/appointments/{$appointment3->json('id')}");
        $responseAppointment3->assertStatus(200)
            ->assertJson([
                'id' => $appointment3->json('id'),
                'status' => $appointment3->json('status'),
                'created_at' => Carbon::parse($appointment3->json('created_at'))->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($appointment3->json('updated_at'))->format('Y-m-d H:i:s'),
                'patient' => [
                    'id' => $this->patients[2]->json('id'),
                    'name' => $this->patients[2]->json('name'),
                    'created_at' => Carbon::parse($this->patients[2]->json('created_at'))->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($this->patients[2]->json('updated_at'))->format('Y-m-d H:i:s'),
                ],
                'diagnose' => [
                    'id' => $this->diagnoses[2]->json('id'),
                    'name' => $this->diagnoses[2]->json('name'),
                    'created_at' => Carbon::parse($this->diagnoses[2]->json('created_at'))->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($this->diagnoses[2]->json('updated_at'))->format('Y-m-d H:i:s'),
                ]
            ]);
    }

    public function test_can_update_appointment()
    {
        $appointment1 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
        ]);
        $updateAppointment1 = [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
            'status' => StatusEnum::SUCCESS,
        ];
        $responseAppointment1 = $this->putJson(uri: "/api/appointments/{$appointment1->json('id')}", data: $updateAppointment1);
        $responseAppointment1->assertStatus(202)
            ->assertJsonFragment(['status' => StatusEnum::SUCCESS])
            ->assertJsonPath('patient.id', $this->patients[0]->json('id'))
            ->assertJsonPath('diagnose.id', $this->diagnoses[0]->json('id'));

        $appointment2 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
        ]);
        $updateAppointment2 = [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
            'status' => StatusEnum::SUCCESS,
        ];
        $responseAppointment2 = $this->putJson(uri: "/api/appointments/{$appointment2->json('id')}", data: $updateAppointment2);
        $responseAppointment2->assertStatus(202)
            ->assertJsonFragment(['status' => StatusEnum::SUCCESS])
            ->assertJsonPath('patient.id', $this->patients[1]->json('id'))
            ->assertJsonPath('diagnose.id', $this->diagnoses[1]->json('id'));

        $appointment3 = $this->postJson(uri: '/api/appointments', data: [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
        ]);
        $updateAppointment3 = [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
            'status' => StatusEnum::SUCCESS,
        ];
        $responseAppointment3 = $this->putJson(uri: "/api/appointments/{$appointment3->json('id')}", data: $updateAppointment3);
        $responseAppointment3->assertStatus(202)
            ->assertJsonFragment(['status' => StatusEnum::SUCCESS])
            ->assertJsonPath('patient.id', $this->patients[2]->json('id'))
            ->assertJsonPath('diagnose.id', $this->diagnoses[2]->json('id'));

        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patients[0]->json('id'),
            'diagnose_id' => $this->diagnoses[0]->json('id'),
            'status' => StatusEnum::SUCCESS,
        ]);
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patients[1]->json('id'),
            'diagnose_id' => $this->diagnoses[1]->json('id'),
            'status' => StatusEnum::SUCCESS,
        ]);
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $this->patients[2]->json('id'),
            'diagnose_id' => $this->diagnoses[2]->json('id'),
            'status' => StatusEnum::SUCCESS,
        ]);
    }
}
