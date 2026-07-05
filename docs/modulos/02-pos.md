# 2. Punto de Venta (POS)

## Qué hace
Creación de pedidos, cobro, división de cuentas, descuentos, propinas y facturación rápida.

## Submódulos
- **Nuevo Pedido** — Selección rápida de productos por categoría, cantidades, notas, modificadores
- **Cobro** — Consolidación de cuenta, aplicación de descuentos y propina, selección de método de pago
- **División de Cuentas** — Reparto equitativo o personalizado entre comensales
- **Descuentos** — Descuentos por línea o por total, con máximo permitido configurable
- **Propinas** — Propina sugerida (%, montos fijos) o personalizada
- **Cierre** — Facturación o ticket final con impresión térmica

## Lógica
- Flujo: seleccionar productos → confirmar pedido → cobrar → imprimir ticket.
- Los precios se toman de `producto_sucursal` o del precio base del producto.
- El impuesto se calcula según el `impuesto` de la sucursal.
- Los modificadores se suman al precio del ítem.
- El precio se congela al agregar al pedido (no cambia si se modifica después).
- **Regla:** no cobrar un pedido con productos sin stock (si aplica recetas).
- **Regla:** pedido no pagado se cancela; pagado solo con nota de crédito.

## Dependencias
Módulos: Menú (1), Mesas (3), Clientes (11), Promociones (14), Pagos (6)
Infra: Sucursales, Usuarios

## APIs
```
POST   /api/pedidos
GET    /api/pedidos/{id}
PUT    /api/pedidos/{id}/estado
POST   /api/pedidos/{id}/pagar
GET    /api/menu?sucursal_id=X
```
