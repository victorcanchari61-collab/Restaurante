# 14. Promociones

## Qué hace
Descuentos, cupones, combos promocionales y programas de fidelización.

## Submódulos
- **Cupones** — Códigos promocionales con condiciones y vigencia
- **Combos Promocionales** — Paquetes con precio especial por tiempo limitado
- **Happy Hour** — Descuentos programados en franja horaria
- **Fidelización** — Recompensas por frecuencia de consumo

## Lógica
- Tipos: `descuento_porcentual`, `descuento_monto`, `2x1`, `combo`, `happy_hour`.
- Reglas en JSON: `{min_compra, productos_aplicables, dias_semana, horas}`.
- Aplica a todas las sucursales o a un subconjunto.
- **Regla:** descuento máximo 99.99%. No acumular a menos que se permita explícitamente.

## Migración
```php
Schema::create('promociones', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->enum('tipo', ['descuento_porcentual', 'descuento_monto', '2x1', 'combo', 'happy_hour']);
    $table->decimal('valor', 10, 2);
    $table->json('reglas')->nullable();
    $table->dateTime('fecha_inicio');
    $table->dateTime('fecha_fin');
    $table->boolean('activo')->default(true);
    $table->timestamps();
});

Schema::create('promocion_sucursal', function (Blueprint $table) {
    $table->id();
    $table->foreignId('promocion_id')->constrained()->cascadeOnDelete();
    $table->foreignId('sucursal_id')->constrained()->cascadeOnDelete();
    $table->unique(['promocion_id', 'sucursal_id']);
});
```

## Dependencias
Módulos: Menú (1)
Infra: Sucursales
