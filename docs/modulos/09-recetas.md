# 9. Recetas

## Qué hace
Vinculación de ingredientes a cada producto del menú para calcular costo y descontar inventario al vender.

## Submódulos
- **Composición** — Ingredientes con cantidad exacta y unidad por producto
- **Costo Unitario** — Cálculo automático (cantidad × costo promedio del ingrediente)
- **Descuento Automático** — Baja de inventario al confirmar pedidos
- **Escalado** — Ajuste de cantidades para producción por lote

## Lógica
- Una receta por producto (opcional).
- Al confirmar pedido, se descuenta inventario ingrediente por ingrediente.
- Costo unitario = suma de (cantidad × costo_promedio del ingrediente).
- **Regla:** si un producto tiene receta, no se vende si falta stock de algún ingrediente.
- **Regla:** modificar receta no afecta pedidos en preparación (precio congelado).

## Migración
```php
Schema::create('recetas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('producto_id')->constrained()->unique()->cascadeOnDelete();
    $table->timestamps();
});

Schema::create('receta_ingredientes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('receta_id')->constrained()->cascadeOnDelete();
    $table->foreignId('ingrediente_id')->constrained();
    $table->decimal('cantidad', 10, 2);
    $table->string('unidad');
    $table->unique(['receta_id', 'ingrediente_id']);
});
```

## Dependencias
Módulos: Menú (1), Inventario (8)
