# 8. Inventario

## Qué hace
Control de ingredientes y materias primas, existencias por sucursal, movimientos y alertas.

## Submódulos
- **Ingredientes** — Catálogo de materias primas con unidad de medida y stock mínimo/máximo
- **Existencias** — Stock actual por sucursal con alertas de reabastecimiento
- **Movimientos** — Registro cronológico: entradas, salidas, mermas, ajustes
- **Transferencias** — Traslado de existencias entre sucursales

## Lógica
- Ingrediente es global; el stock se maneja por sucursal (`ingrediente_sucursal`).
- Todo movimiento tiene: usuario, motivo, sucursal, referencia (OC, pedido, etc.).
- Alerta automática cuando stock cae bajo el mínimo.
- **Regla:** no dar salida mayor al stock disponible.
- **Regla:** merma requiere motivo obligatorio.

## Migración
```php
Schema::create('ingredientes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('unidad_medida');
    $table->decimal('stock_minimo', 10, 2)->default(0);
    $table->timestamps();
});

Schema::create('ingrediente_sucursal', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ingrediente_id')->constrained()->cascadeOnDelete();
    $table->foreignId('sucursal_id')->constrained()->cascadeOnDelete();
    $table->decimal('stock_actual', 10, 2)->default(0);
    $table->decimal('stock_maximo', 10, 2)->nullable();
    $table->unique(['ingrediente_id', 'sucursal_id']);
});

Schema::create('inventario_movimientos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ingrediente_id')->constrained();
    $table->foreignId('sucursal_id')->constrained();
    $table->enum('tipo', ['entrada', 'salida', 'merma', 'ajuste', 'transferencia']);
    $table->decimal('cantidad', 10, 2);
    $table->decimal('stock_resultante', 10, 2);
    $table->string('motivo')->nullable();
    $table->morphs('origen');
    $table->foreignId('usuario_id')->constrained();
    $table->timestamps();
});
```

## Dependencias
Módulos: Recetas (9), Compras (10)
Infra: Sucursales
