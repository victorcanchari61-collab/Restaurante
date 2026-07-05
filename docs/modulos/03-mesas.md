# 3. Gestión de Mesas

## Qué hace
Plano interactivo del restaurante, control de ocupación, reservas y rotación.

## Submódulos
- **Plano Interactivo** — Vista gráfica drag & drop para asignar mesas
- **Ocupación** — Control de estados: libre, ocupada, reservada, por pagar, sucia
- **Reservas** — Agenda con datos del cliente, hora y número de personas
- **Historial** — Tiempo de estancia, facturación acumulada por mesa, rotación

## Lógica
- Cada mesa pertenece a una sucursal.
- Al ocupar una mesa se crea un pedido y se asocia.
- Al pagar, la mesa pasa a `por_pagar` → `sucia` → `libre`.
- **Regla:** no ocupar mesa ya ocupada o reservada.
- **Regla:** cambiar mesa transfiere el pedido abierto a la nueva.

## Migración
```php
Schema::create('mesas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sucursal_id')->constrained()->cascadeOnDelete();
    $table->string('nombre');
    $table->integer('capacidad');
    $table->integer('posicion_x');
    $table->integer('posicion_y');
    $table->enum('estado', ['libre','ocupada','reservada','por_pagar','sucia'])->default('libre');
    $table->foreignId('pedido_id')->nullable()->constrained();
    $table->timestamps();
});
```

## APIs
```
GET    /api/sucursales/{id}/mesas
POST   /api/mesas/{id}/ocupar
POST   /api/mesas/{id}/liberar
```

## Dependencias
Infra: Sucursales
