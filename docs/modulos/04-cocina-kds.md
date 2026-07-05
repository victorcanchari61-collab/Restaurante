# 4. Cocina (KDS — Kitchen Display System)

## Qué hace
Pantalla dedicada donde los pedidos entrantes se muestran en tiempo real para que los cocineros gestionen la preparación.

## Submódulos
- **Pantalla de Pedidos** — Visualización en tiempo real de pedidos entrantes agrupados
- **Estados** — Flujo por ítem: pendiente → en preparación → listo
- **Tiempos** — Control de tiempo de preparación por platillo
- **Notificaciones** — Alertas sonoras para pedidos nuevos o urgentes

## Lógica
- Cada producto individual tiene estado: `pendiente` → `en_preparacion` → `listo`.
- Cuando todos los productos están `listos`, el pedido pasa a `listo`.
- El tiempo se mide desde que el cocinero marca "en preparación" hasta "listo".
- Actualización en tiempo real (Polling, SSE o WebSockets).
- **Regla:** solo muestra pedidos de la sucursal del cocinero autenticado.

## APIs
```
GET    /api/cocina/pedidos
PUT    /api/cocina/pedidos/{id}/preparar
PUT    /api/cocina/pedidos/{id}/listo
```

## Dependencias
Módulos: POS (2)
