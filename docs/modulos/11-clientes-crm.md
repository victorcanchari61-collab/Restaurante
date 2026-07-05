# 11. Clientes (CRM)

## Qué hace
Gestión de clientes, historial de compras, puntos de fidelización y segmentación.

## Submódulos
- **Perfil** — Datos de contacto, preferencias, cumpleaños, segmento
- **Historial de Compras** — Pedidos del cliente, tickets, productos favoritos
- **Puntos y Fidelización** — Acumulación, canje, niveles, vencimiento
- **Segmentación** — Grupos para campañas promocionales

## Lógica
- Cliente opcional en pedido (se vende sin identificarlo).
- Puntos: regla configurable (ej. S/10 = 1 punto). Se acreditan al pagar.
- Si se anula un pedido pagado, se revierten los puntos.
- **Regla:** puntos se acreditan cuando el pedido se paga, no antes.

## Migración
```php
Schema::create('clientes', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('email')->nullable()->unique();
    $table->string('telefono', 30)->nullable();
    $table->date('fecha_nacimiento')->nullable();
    $table->integer('puntos')->default(0);
    $table->string('segmento')->nullable();
    $table->timestamps();
});
```

## APIs
```
GET    /api/clientes
GET    /api/clientes/{id}/historial
POST   /api/clientes/{id}/puntos
```

## Dependencias
Módulos: POS (2)
