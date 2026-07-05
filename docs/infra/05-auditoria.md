# Auditoría

## Qué hace
Registro detallado de todas las acciones de los usuarios sobre los modelos.

## Lógica
- Implementación vía Observer o Spatie Activitylog.
- Registra: usuario, acción, modelo, datos anteriores/nuevos, IP, user-agent.
- Logs no eliminables (retención configurable).
- Panel de consulta con filtros avanzados y exportación.

## Migración
```php
Schema::create('auditoria_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('usuario_id')->nullable()->constrained();
    $table->string('accion');
    $table->string('modelo');
    $table->unsignedBigInteger('modelo_id');
    $table->json('datos_viejos')->nullable();
    $table->json('datos_nuevos')->nullable();
    $table->string('ip')->nullable();
    $table->string('user_agent')->nullable();
    $table->timestamps();
    $table->index(['modelo', 'modelo_id']);
});
```
