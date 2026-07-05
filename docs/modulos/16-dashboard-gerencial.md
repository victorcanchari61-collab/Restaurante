# 16. Dashboard Gerencial

## Qué hace
Indicadores clave en tiempo real para la administración.

## Submódulos
- **Resumen en Vivo** — Ventas, pedidos y ocupación actualizados al instante
- **Comparativas** — KPIs side-by-side entre sucursales y vs períodos anteriores
- **Alertas** — Indicadores fuera de rango con notificaciones visuales
- **Metas** — Progreso hacia objetivos diarios, semanales y mensuales

## Lógica
- KPIs: ventas del día, ticket promedio, ocupación (%), pedidos en cocina, tops.
- Widgets Filament en el Escritorio (`/admin`).

## APIs
```
GET    /api/dashboard/resumen
GET    /api/dashboard/ventas-hoy
GET    /api/dashboard/ocupacion
```
