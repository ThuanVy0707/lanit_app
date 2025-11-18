<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_clients(): void
    {
        $user = User::factory()->create();
        Client::factory(5)->create(['owner_user_id' => $user->id]);

        $response = $this->getJson('/api/v1/clients');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'client_id',
                        'uuid',
                        'firstname',
                        'lastname',
                        'fullname',
                        'email',
                        'status',
                    ],
                ],
            ]);
    }

    public function test_can_create_client(): void
    {
        $user = User::factory()->create();
        $clientData = [
            'owner_user_id' => $user->id,
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john.doe@example.com',
            'status' => 'Active',
        ];

        $response = $this->postJson('/api/v1/clients', $clientData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'john.doe@example.com',
            ]);

        $this->assertDatabaseHas('clients', [
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_can_show_client_with_stats(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['owner_user_id' => $user->id]);

        $response = $this->getJson("/api/v1/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'result',
                'client' => [
                    'client_id',
                    'uuid',
                    'firstname',
                    'lastname',
                    'email',
                ],
                'stats' => [
                    'numdueinvoices',
                    'numactivedomains',
                    'numtickets',
                ],
            ]);
    }

    public function test_can_update_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['owner_user_id' => $user->id]);

        $updateData = [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
        ];

        $response = $this->putJson("/api/v1/clients/{$client->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'firstname' => 'Jane',
                'lastname' => 'Smith',
            ]);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'firstname' => 'Jane',
            'lastname' => 'Smith',
        ]);
    }

    public function test_can_delete_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['owner_user_id' => $user->id]);

        $response = $this->deleteJson("/api/v1/clients/{$client->id}");

        $response->assertStatus(200)
            ->assertJsonFragment([
                'result' => 'success',
            ]);

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }

    public function test_validation_errors_on_create_client(): void
    {
        $response = $this->postJson('/api/v1/clients', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['firstname', 'lastname', 'email']);
    }
}
