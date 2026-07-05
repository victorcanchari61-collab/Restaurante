# 5. Caja

## Qué hace
Apertura y cierre de caja, arqueos, retiros e ingresos de efectivo, control de fondo fijo.

## Submódulos
- **Apertura** — Registro de fondo inicial por turno y usuario
- **Arqueo** — Conteo de efectivo y diferencia con el esperado del sistema
- **Movimientos** — Retiros e ingresos durante el turno con motivo
- **Cierre** — Corte de caja con resumen de transacciones y depósito

## Lógica
- Cada turno (mañana/tarde/noche) tiene apertura con monto inicial.
- Durante el turno se registran retiros e ingresos.
- Al cerrar se hace arqueo: efectivo contado vs esperado.
- **Regla:** no cerrar caja si hay pedidos abiertos en la sucursal.
- **Regla:** solo quien abrió la caja puede cerrarla (o un Admin).

## Migración
```php
Schema::create('caja_turnos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sucursal_id')->constrained();
    $table->foreignId('usuario_id')->constrained();
    $table->dateTime('apertura');
    $table->dateTime('cierre')->nullable();
    $table->decimal('monto_inicial', 10, 2);
    $table->decimal('monto_esperado', 10, 2)->nullable();
    $table->decimal('monto_real', 10, 2)->nullable();
    $table->decimal('diferencia', 10, 2)->nullable();
    $table->enum('estado', ['abierta', 'cerrada', 'auditada'])->default('abierta');
});

Schema::create('caja_movimientos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('caja_turno_id')->constrained()->cascadeOnDelete();
    $table->enum('tipo', ['retiro', 'ingreso']);
    $table->decimal('monto', 10, 2);
    $table->string('motivo');
    $table->foreignId('usuario_id')->constrained();
    $table->timestamps();
});
```

## APIs
```
POST   /api/caja/apertura
POST   /api/caja/cierre
POST   /api/caja/retiro
POST   /api/caja/ingreso
GET    /api/caja/movimientos
```

## Dependencias
Infra: Sucursales, Usuarios
Módulos: Pagos (6)
