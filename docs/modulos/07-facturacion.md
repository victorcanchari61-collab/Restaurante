# 7. Facturación

## Qué hace
Generación de facturas, boletas, notas de crédito y débito con integración tributaria.

## Submódulos
- **Facturas** — Emisión con datos fiscales del cliente (RUC, razón social)
- **Boletas** — Comprobante simplificado para consumidor final
- **Notas de Crédito/Débito** — Anulación y corrección de comprobantes
- **Tributación** — Integración con APIs de SUNAT/SAT/SII

## Lógica
- Serie y correlativo por sucursal y tipo (ej. B001-000001).
- Factura requiere RUC. Boleta es para consumidor final.
- **Regla:** no facturar un pedido no pagado.
- **Regla:** serie y correlativo autoincrementales por sucursal-tipo.

## Migración
```php
Schema::create('facturas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sucursal_id')->constrained();
    $table->foreignId('pedido_id')->constrained();
    $table->foreignId('cliente_id')->nullable()->constrained();
    $table->enum('tipo', ['factura', 'boleta', 'nota_credito', 'nota_debito']);
    $table->string('serie', 4);
    $table->string('numero', 10);
    $table->decimal('total', 10, 2);
    $table->string('moneda', 3)->default('PEN');
    $table->string('xml')->nullable();
    $table->string('estado_sunat')->nullable();
    $table->foreignId('factura_referencia_id')->nullable()->constrained('facturas');
    $table->timestamps();
});
```

## APIs
```
POST   /api/facturas
GET    /api/facturas/{id}
POST   /api/facturas/{id}/nota-credito
```

## Dependencias
Módulos: POS (2), Pagos (6), Clientes (11)
Infra: Sucursales
