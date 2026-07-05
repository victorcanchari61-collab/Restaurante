# 12. Proveedores

## Qué hace
Registro de proveedores, productos que suministran, historial de compras y evaluación.

## Submódulos
- **Registro** — Datos fiscales (RUC), contacto, clasificación
- **Productos Suministrados** — Ingredientes que ofrece con precio de referencia
- **Evaluación** — Calificación por cumplimiento, calidad y precio
- **Pagos** — Cuentas por pagar y registro de transacciones

## Lógica
- Un proveedor suministra múltiples ingredientes.
- Evaluación: puntuación 1-5 por criterios.
- **Regla:** no eliminar proveedor con órdenes de compra activas.

## Migración
```php
Schema::create('proveedores', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('contacto')->nullable();
    $table->string('telefono', 30)->nullable();
    $table->string('email')->nullable();
    $table->text('direccion')->nullable();
    $table->string('ruc', 20)->nullable();
    $table->decimal('calificacion', 2, 1)->nullable();
    $table->timestamps();
});

Schema::create('proveedor_ingredientes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('proveedor_id')->constrained()->cascadeOnDelete();
    $table->foreignId('ingrediente_id')->constrained()->cascadeOnDelete();
    $table->decimal('precio_referencia', 10, 2);
    $table->unique(['proveedor_id', 'ingrediente_id']);
});
```

## Dependencias
Módulos: Inventario (8)
