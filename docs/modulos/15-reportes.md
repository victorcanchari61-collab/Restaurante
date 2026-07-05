# 15. Reportes

## Qué hace
Reportes analíticos de ventas, productos, inventario y desempeño por sucursal.

## Submódulos
- **Ventas** — Ingresos por período, sucursal, método de pago, tipo de pedido
- **Productos** — Ranking de más vendidos, rentabilidad, rotación
- **Inventario** — Movimientos, mermas, proyección de consumo
- **Caja** — Corte por turno, diferencias, depósitos
- **Comparativo** — Desempeño entre sucursales y períodos

## Lógica
- Filtros: rango de fechas, sucursal(es), tipo de pedido.
- Datos en tiempo real desde la BD.
- Exportación a PDF, Excel, CSV.
- **Regla:** cajero ve solo su sucursal; Admin ve todas.

## APIs
```
GET    /api/reportes/ventas
GET    /api/reportes/productos-mas-vendidos
GET    /api/reportes/utilidades
GET    /api/reportes/inventario
```
