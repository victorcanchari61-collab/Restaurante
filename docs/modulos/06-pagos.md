# 6. Pagos

## Qué hace
Múltiples métodos de pago por pedido, incluyendo pago mixto (split payment).

## Submódulos
- **Efectivo** — Cobro con cálculo de vuelto
- **Tarjeta** — Integración con terminales POS y pasarelas
- **Transferencias** — Depósitos bancarios y transferencias electrónicas
- **Billeteras Digitales** — Yape, Plin, Mercado Pago, PayPal
- **Pago Mixto** — División de cuenta con combinación de métodos

## Lógica
- Un pedido puede pagarse con múltiples métodos (ej. S/20 efectivo + S/30 tarjeta).
- En efectivo se calcula el vuelto automáticamente.
- **Regla:** suma de pagos = total del pedido (± tolerancia configurable).
- **Regla:** un pedido pagado no se modifica.

## Migración
```php
Schema::create('pagos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pedido_id')->constrained()->cascadeOnDelete();
    $table->enum('metodo', ['efectivo', 'tarjeta_debito', 'tarjeta_credito', 'transferencia', 'yape', 'plin', 'mercado_pago', 'otros']);
    $table->decimal('monto', 10, 2);
    $table->string('referencia')->nullable();
    $table->decimal('vuelto', 10, 2)->default(0);
    $table->timestamps();
});
```

## Dependencias
Módulos: POS (2)
