<?php

namespace Tests\Feature;

use App\Models\Sucursal;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SucursalApiTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);

        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('Super Admin');
    }

    public function test_guest_cannot_list_sucursales(): void
    {
        $this->getJson('/api/sucursales')->assertUnauthorized();
    }

    public function test_user_without_permission_cannot_list_sucursales(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api')
            ->getJson('/api/sucursales')
            ->assertForbidden();
    }

    public function test_super_admin_can_create_sucursal(): void
    {
        $this->actingAs($this->superAdmin, 'api')
            ->postJson('/api/sucursales', [
                'nombre' => 'Sucursal Centro',
                'direccion' => 'Av. Principal 123',
                'telefono' => '999888777',
                'impuesto' => 18,
                'horarios' => ['lunes-viernes' => '09:00-22:00'],
            ])
            ->assertCreated()
            ->assertJsonPath('data.nombre', 'Sucursal Centro');

        $this->assertDatabaseHas('sucursales', ['nombre' => 'Sucursal Centro']);
    }

    public function test_create_sucursal_requires_nombre(): void
    {
        $this->actingAs($this->superAdmin, 'api')
            ->postJson('/api/sucursales', ['direccion' => 'Sin nombre'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['nombre']);
    }

    public function test_super_admin_can_list_show_update_and_delete_sucursal(): void
    {
        $sucursal = Sucursal::factory()->create();

        $this->actingAs($this->superAdmin, 'api')
            ->getJson('/api/sucursales')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->actingAs($this->superAdmin, 'api')
            ->getJson("/api/sucursales/{$sucursal->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $sucursal->id);

        $this->actingAs($this->superAdmin, 'api')
            ->putJson("/api/sucursales/{$sucursal->id}", ['nombre' => 'Renombrada'])
            ->assertOk()
            ->assertJsonPath('data.nombre', 'Renombrada');

        $this->actingAs($this->superAdmin, 'api')
            ->deleteJson("/api/sucursales/{$sucursal->id}")
            ->assertOk();

        $this->assertDatabaseMissing('sucursales', ['id' => $sucursal->id]);
    }
}
