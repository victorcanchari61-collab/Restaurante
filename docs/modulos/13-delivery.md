# 13. Delivery

## Qué hace
Asignación de repartidores, seguimiento en tiempo real, zonas de entrega y tarifas dinámicas.

## Submódulos
- **Repartidores** — Registro, disponibilidad, zona de cobertura
- **Zonas de Entrega** — Geocercas con tarifas y tiempos estimados
- **Tarifas** — Costo dinámico por distancia, hora y demanda
- **Seguimiento** — Mapa en tiempo real con estado del envío

## Lógica
- Repartidores con estado: disponible, en_entrega, descanso, inactivo.
- Seguimiento: asignado → recogido → en_camino → entregado.
- **Regla:** un repartidor solo tiene un pedido activo a la vez.
- **Regla:** zonas de entrega se definen por sucursal.

## Migración
```php
Schema::create('repartidores', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sucursal_id')->constrained();
    $table->string('nombre');
    $table->string('telefono', 30);
    $table->string('vehiculo')->nullable();
    $table->enum('estado', ['disponible', 'en_entrega', 'descanso', 'inactivo'])->default('disponible');
    $table->timestamps();
});

Schema::create('zonas_entrega', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sucursal_id')->constrained();
    $table->string('nombre');
    $table->decimal('tarifa', 10, 2);
    $table->integer('tiempo_estimado_minutos');
    $table->json('poligono')->nullable();
});
```

## APIs
```
POST   /api/delivery/asignar
GET    /api/delivery/seguimiento/{id}
```

## Dependencias
Módulos: POS (2)
Infra: Sucursales
