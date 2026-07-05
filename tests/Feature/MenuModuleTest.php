<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuModuleTest extends TestCase
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

    public function test_guest_cannot_access_menu_module(): void
    {
        $this->getJson('/api/categorias')->assertUnauthorized();
        $this->getJson('/api/productos')->assertUnauthorized();
        $this->getJson('/api/menu')->assertUnauthorized();
    }

    public function test_user_without_permission_cannot_manage_categorias(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api')
            ->postJson('/api/categorias', ['nombre' => 'Entradas'])
            ->assertForbidden();
    }

    public function test_crud_categoria(): void
    {
        $this->actingAs($this->superAdmin, 'api')
            ->postJson('/api/categorias', ['nombre' => 'Entradas', 'orden' => 1])
            ->assertCreated()
            ->assertJsonPath('data.nombre', 'Entradas');

        $categoria = Categoria::first();

        $this->actingAs($this->superAdmin, 'api')
            ->putJson("/api/categorias/{$categoria->id}", ['nombre' => 'Entradas frías'])
            ->assertOk()
            ->assertJsonPath('data.nombre', 'Entradas frías');

        $this->actingAs($this->superAdmin, 'api')
            ->deleteJson("/api/categorias/{$categoria->id}")
            ->assertOk();

        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }

    public function test_categoria_con_productos_no_se_puede_eliminar(): void
    {
        $producto = Producto::factory()->create();

        $this->actingAs($this->superAdmin, 'api')
            ->deleteJson("/api/categorias/{$producto->categoria_id}")
            ->assertUnprocessable();

        $this->assertDatabaseHas('categorias', ['id' => $producto->categoria_id]);
    }

    public function test_crud_producto_con_precio_por_sucursal(): void
    {
        $categoria = Categoria::factory()->create();
        $sucursal = Sucursal::factory()->create();

        $response = $this->actingAs($this->superAdmin, 'api')
            ->postJson('/api/productos', [
                'categoria_id' => $categoria->id,
                'nombre' => 'Lomo Saltado',
                'precio' => 35.00,
                'tipo' => 'plato',
                'modificadores' => [
                    ['nombre' => 'Porción extra de arroz', 'precio' => 5.00],
                ],
                'sucursales' => [
                    ['sucursal_id' => $sucursal->id, 'precio' => 39.90, 'disponible' => true],
                ],
            ])
            ->assertCreated()
            ->assertJsonPath('data.nombre', 'Lomo Saltado')
            ->assertJsonPath('data.sucursales.0.precio', 39.9);

        $productoId = $response->json('data.id');

        $this->assertDatabaseHas('producto_sucursal', [
            'producto_id' => $productoId,
            'sucursal_id' => $sucursal->id,
        ]);

        $this->actingAs($this->superAdmin, 'api')
            ->deleteJson("/api/productos/{$productoId}")
            ->assertOk();

        $this->assertDatabaseMissing('productos', ['id' => $productoId]);
    }

    public function test_menu_resuelve_precio_y_disponibilidad_por_sucursal(): void
    {
        $sucursal = Sucursal::factory()->create();
        $categoria = Categoria::factory()->create(['orden' => 1]);

        $conOverride = Producto::factory()->create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Ceviche',
            'precio' => 30.00,
        ]);
        $conOverride->sucursales()->attach($sucursal->id, ['precio' => 34.50, 'disponible' => true]);

        $noDisponible = Producto::factory()->create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Chicharrón',
            'precio' => 28.00,
        ]);
        $noDisponible->sucursales()->attach($sucursal->id, ['precio' => null, 'disponible' => false]);

        Producto::factory()->create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Arroz con pollo',
            'precio' => 22.00,
        ]);

        $response = $this->actingAs($this->superAdmin, 'api')
            ->getJson("/api/menu?sucursal_id={$sucursal->id}")
            ->assertOk()
            ->json('data');

        $productos = collect($response[0]['productos']);

        $this->assertCount(2, $productos);
        $this->assertSame(34.5, (float) $productos->firstWhere('nombre', 'Ceviche')['precio']);
        $this->assertSame(22.0, (float) $productos->firstWhere('nombre', 'Arroz con pollo')['precio']);
        $this->assertNull($productos->firstWhere('nombre', 'Chicharrón'));
    }

    public function test_menu_oculta_categorias_y_productos_inactivos(): void
    {
        $activa = Categoria::factory()->create(['nombre' => 'Activa']);
        $inactiva = Categoria::factory()->create(['nombre' => 'Inactiva', 'activo' => false]);

        Producto::factory()->create(['categoria_id' => $activa->id, 'nombre' => 'Visible']);
        Producto::factory()->create(['categoria_id' => $activa->id, 'nombre' => 'Oculto', 'activo' => false]);
        Producto::factory()->create(['categoria_id' => $inactiva->id, 'nombre' => 'De inactiva']);

        $data = $this->actingAs($this->superAdmin, 'api')
            ->getJson('/api/menu')
            ->assertOk()
            ->json('data');

        $this->assertCount(1, $data);
        $this->assertSame('Activa', $data[0]['nombre']);
        $this->assertCount(1, $data[0]['productos']);
        $this->assertSame('Visible', $data[0]['productos'][0]['nombre']);
    }
}
