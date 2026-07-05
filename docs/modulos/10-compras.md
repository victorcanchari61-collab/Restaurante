# 10. Compras

## Qué hace
Órdenes de compra a proveedores, recepción de productos y actualización de inventario.

## Submódulos
- **Órdenes de Compra** — Creación, autorización, envío a proveedor
- **Recepción** — Ingreso parcial o total con actualización automática de stock
- **Historial de Precios** — Seguimiento de precios por ingrediente y proveedor

## Lógica
- Estados: `borrador` → `enviada` → `recibida_parcial/total` o `cancelada`.
- Al recibir se genera movimiento de entrada en inventario.
- **Regla:** solo modificar OC en estado `borrador`.
- **Regla:** cantidad recibida no supera lo solicitado.

## Migración
```php
Schema::create('ordenes_compra', function (Blueprint $table) {
    $table->id();
    $table->foreignId('proveedor_id')->constrained();
    $table->foreignId('sucursal_id')->constrained();
    $table->foreignId('usuario_id')->constrained();
    $table->date('fecha_orden');
    $table->date('fecha_entrega_estimada')->nullable();
    $table->enum('estado', ['borrador','enviada','recibida_parcial','recibida_total','cancelada'])->default('borrador');
    $table->decimal('total', 10, 2);
    $table->timestamps();
});

Schema::create('orden_compra_detalles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('orden_compra_id')->constrained()->cascadeOnDelete();
    $table->foreignId('ingrediente_id')->constrained();
    $table->decimal('cantidad', 10, 2);
    $table->decimal('precio_unitario', 10, 2);
    $table->decimal('cantidad_recibida', 10, 2)->default(0);
});
```

## Dependencias
Módulos: Inventario (8), Proveedores (12)
Infra: Sucursales
