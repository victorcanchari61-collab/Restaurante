# Sucursales

## Qué hace
Registro de cada local de la cadena. No es un módulo funcional, es una entidad transversal que da contexto a todos los módulos (cada pedido, mesa, caja, etc. pertenece a una sucursal).

## Lógica
- Campos: nombre, dirección, teléfono, horarios (JSON), impuesto (%), activo.
- Un usuario puede pertenecer a una sucursal (`users.sucursal_id`, opcional).
- Al eliminar sucursal, sus usuarios quedan sin sucursal (`nullOnDelete`).
- El impuesto de la sucursal lo usa el POS al facturar.
- Toda tabla operativa lleva `sucursal_id` con Global Scope para aislamiento.

## Migración
```php
Schema::create('sucursales', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('direccion')->nullable();
    $table->string('telefono', 30)->nullable();
    $table->json('horarios')->nullable();
    $table->decimal('impuesto', 5, 2)->default(0);
    $table->boolean('activo')->default(true);
    $table->timestamps();
});
```
