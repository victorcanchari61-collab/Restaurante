# Módulos del Sistema Restaurante

## Módulos funcionales (negocio)

| # | Módulo | Archivo | Estado |
|---|--------|---------|--------|
| 1 | Menú y Productos | [📄](modulos/01-menu-productos.md) | 🚧 En desarrollo |
| 2 | Punto de Venta (POS) | [📄](modulos/02-pos.md) | ⏳ Pendiente |
| 3 | Gestión de Mesas | [📄](modulos/03-mesas.md) | ⏳ Pendiente |
| 4 | Cocina (KDS) | [📄](modulos/04-cocina-kds.md) | ⏳ Pendiente |
| 5 | Caja | [📄](modulos/05-caja.md) | ⏳ Pendiente |
| 6 | Pagos | [📄](modulos/06-pagos.md) | ⏳ Pendiente |
| 7 | Facturación | [📄](modulos/07-facturacion.md) | ⏳ Pendiente |
| 8 | Inventario | [📄](modulos/08-inventario.md) | ⏳ Pendiente |
| 9 | Recetas | [📄](modulos/09-recetas.md) | ⏳ Pendiente |
| 10 | Compras | [📄](modulos/10-compras.md) | ⏳ Pendiente |
| 11 | Clientes (CRM) | [📄](modulos/11-clientes-crm.md) | ⏳ Pendiente |
| 12 | Proveedores | [📄](modulos/12-proveedores.md) | ⏳ Pendiente |
| 13 | Delivery | [📄](modulos/13-delivery.md) | ⏳ Pendiente |
| 14 | Promociones | [📄](modulos/14-promociones.md) | ⏳ Pendiente |
| 15 | Reportes | [📄](modulos/15-reportes.md) | ⏳ Pendiente |
| 16 | Dashboard Gerencial | [📄](modulos/16-dashboard-gerencial.md) | ⏳ Pendiente |

## Infraestructura transversal

Estos no son módulos, son capacidades transversales que usan todos los módulos.

| Componente | Archivo | Estado |
|------------|---------|--------|
| Autenticación (JWT) | [📄](infra/01-autenticacion.md) | ✅ Implementado |
| Sucursales | [📄](infra/02-sucursales.md) | ✅ Implementado |
| Usuarios y Roles | [📄](infra/03-usuarios-roles.md) | ✅ Implementado |
| Configuración General | [📄](infra/04-configuracion-general.md) | ⏳ Pendiente |
| Auditoría | [📄](infra/05-auditoria.md) | ⏳ Pendiente |
| Notificaciones | [📄](infra/06-notificaciones.md) | ⏳ Pendiente |

## Dependencias

```
Menú ──────────────┬──→ POS
                   ├──→ Recetas → Inventario
                   └──→ Promociones

POS ───────────────┬──→ Cocina (KDS)
                   ├──→ Pagos → Caja
                   └──→ Facturación

Compras ───────────→ Inventario
Proveedores ───────→ Compras
Clientes ──────────→ POS, Facturación, Promociones
```

## Orden de implementación

```
Fase 1 — Base operativa
  1. Menú y Productos ← empezar aquí
  2. POS
  3. Mesas
  5. Caja
  6. Pagos

Fase 2 — Cocina e inventario
  4. Cocina (KDS)
  8. Inventario
  9. Recetas

Fase 3 — Abastecimiento
  12. Proveedores
  10. Compras

Fase 4 — Clientes y facturación
  11. Clientes (CRM)
  7. Facturación
  13. Delivery
  14. Promociones

Fase 5 — Visibilidad
  15. Reportes
  16. Dashboard Gerencial
```
