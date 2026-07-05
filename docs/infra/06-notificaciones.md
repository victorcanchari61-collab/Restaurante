# Notificaciones

## Qué hace
Alertas automáticas sobre eventos importantes del sistema.

## Lógica
- Eventos: inventario bajo, pedido nuevo en cocina, compras por recibir, caja pendiente, vencimiento próximo.
- Canales: app (Filament), correo, pantalla KDS, sonido.
- Usuario configura qué notificaciones recibe y por qué canal.

## Migración
```php
Schema::create('notificaciones', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type');
    $table->morphs('notifiable');
    $table->text('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
});
```
