# 1. Menú y Productos

## Qué hace
Catálogo de lo que vende el restaurante, organizado en categorías, con precios por sucursal. Es la base de todos los módulos operativos (POS, inventario, promociones).

## Submódulos
- **Categorías** — Agrupación jerárquica de productos, ordenable, activable/desactivable
- **Productos** — CRUD completo con nombre, descripción, precio base, imágenes, tipo
- **Modificadores** — Opciones extras configurables por producto con precio adicional
- **Precios por Sucursal** — Tabla pivote para precios diferenciados y disponibilidad por local
- **Combos** — Agrupación de productos con precio especial

## Lógica
- Categorías ordenables y desactivables. Una inactiva oculta todos sus productos del menú.
- Producto tiene precio base global. El pivote `producto_sucursal` permite override de precio y disponibilidad por sucursal. Si no hay pivote, rige precio base.
- Modificadores: lista JSON de extras `[{nombre, precio}]` que el POS suma al ítem.
- **Regla:** no eliminar categoría con productos (FK restrict).
- **Regla:** al desactivar un producto, no se muestra en ninguna sucursal.

## Dependencias
Infra: Sucursales

## Migraciones
```php
Schema::create('categorias', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->text('descripcion')->nullable();
    $table->string('imagen')->nullable();
    $table->integer('orden')->default(0);
    $table->boolean('activo')->default(true);
    $table->timestamps();
});

Schema::create('productos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('categoria_id')->constrained()->restrictOnDelete();
    $table->string('nombre');
    $table->text('descripcion')->nullable();
    $table->decimal('precio_base', 10, 2);
    $table->string('imagen')->nullable();
    $table->enum('tipo', ['plato', 'bebida', 'combo'])->default('plato');
    $table->json('modificadores')->nullable();
    $table->boolean('activo')->default(true);
    $table->timestamps();
});

Schema::create('producto_sucursal', function (Blueprint $table) {
    $table->id();
    $table->foreignId('producto_id')->constrained()->cascadeOnDelete();
    $table->foreignId('sucursal_id')->constrained()->cascadeOnDelete();
    $table->decimal('precio', 10, 2)->nullable();
    $table->boolean('disponible')->default(true);
    $table->unique(['producto_id', 'sucursal_id']);
});
```

## APIs
```
GET    /api/menu?sucursal_id=X
GET    /api/categorias
GET    /api/productos
POST   /api/productos
PUT    /api/productos/{id}
```

## Permisos
`categoria.*`, `producto.*`
