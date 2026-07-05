# Restaurante — Sistema de Gestión para Cadena de Restaurantes

Sistema modular tipo ERP para administrar una **cadena de restaurantes** con múltiples sucursales desde una plataforma centralizada. Proporciona control independiente por cada local con información consolidada para la administración general.

---

## Stack Tecnológico

| Componente        | Tecnología                                     |
| ----------------- | ---------------------------------------------- |
| Backend           | Laravel 13 + PHP 8.3                           |
| Base de datos     | MySQL                                          |
| Admin panel       | Filament 3 (panel administrativo)              |
| API               | REST con JWT (tymon/jwt-auth)                  |
| RBAC              | Spatie Laravel Permission                      |
| Frontend          | Tailwind CSS 4 + Vite 8                        |

---

## Arquitectura

```
Restaurante (Sistema Central)
│
├── Administración General
│   ├── Sucursales
│   ├── Usuarios y Roles
│   ├── Reportes Globales
│   └── Configuración del Sistema
│
├── Sucursal A
│   ├── POS / Pedidos
│   ├── Mesas
│   ├── Cocina (KDS)
│   ├── Inventario
│   ├── Caja
│   └── Delivery
│
├── Sucursal B
│   ├── POS / Pedidos
│   ├── Mesas
│   ├── Cocina (KDS)
│   ├── Inventario
│   ├── Caja
│   └── Delivery
│
└── Base de Datos Central
    ├── Clientes
    ├── Productos y Menú
    ├── Ventas
    ├── Compras
    ├── Reportes
    └── Auditoría
```

Cada sucursal opera de forma independiente en su operación diaria (POS, cocina, caja), mientras que la administración central mantiene visibilidad y control sobre todas ellas.

---

## Módulos del Sistema

| # | Módulo | Estado |
|---|--------|--------|
| 1 | Menú y Productos | 🚧 En desarrollo |
| 2 | Punto de Venta (POS) | ⏳ Pendiente |
| 3 | Gestión de Mesas | ⏳ Pendiente |
| 4 | Cocina (KDS) | ⏳ Pendiente |
| 5 | Caja | ⏳ Pendiente |
| 6 | Pagos | ⏳ Pendiente |
| 7 | Facturación | ⏳ Pendiente |
| 8 | Inventario | ⏳ Pendiente |
| 9 | Recetas | ⏳ Pendiente |
| 10 | Compras | ⏳ Pendiente |
| 11 | Clientes (CRM) | ⏳ Pendiente |
| 12 | Proveedores | ⏳ Pendiente |
| 13 | Delivery | ⏳ Pendiente |
| 14 | Promociones | ⏳ Pendiente |
| 15 | Reportes | ⏳ Pendiente |
| 16 | Dashboard Gerencial | ⏳ Pendiente |

> Documentación detallada (lógica, reglas, migraciones, APIs) en [`docs/modulos/`](docs/modulos/).  
> Infraestructura transversal (Sucursales, Usuarios, Auth, etc.) en [`docs/infra/`](docs/infra/).

---

## Estado Actual del Proyecto

### Implementado
- Autenticación JWT (login, logout, refresh, me)
- Panel administrativo Filament con tema personalizado (sidebar oscuro con degradado, login con imagen de restaurante)
- RBAC completo (Spatie Permission) con CRUD de usuarios, roles y permisos en Filament
- Roles predefinidos: Super Admin, Admin, Cajero, Cocinero, Mesero
- Migraciones: users, permissions, roles, jobs, cache

### Por Implementar
Toda la lógica de dominio del restaurante: modelos, controladores, migraciones, recursos Filament, tests y rutas API para cada módulo listado anteriormente.

---

## Base de Datos — Diagrama Conceptual

```
sucursales
├── id, nombre, direccion, telefono, horarios, impuestos, activo

usuarios
├── id, name, email, username, password, sucursal_id (opcional)
├── roles (Spatie)
└── permissions (Spatie)

categorias
├── id, nombre, descripcion, imagen, activo

productos
├── id, categoria_id, nombre, descripcion, precio, imagen, tipo (plato/bebida/combo)
└── modificadores (json o tabla relacionada)

recetas
├── id, producto_id
└── ingredientes (tabla pivote: ingrediente_id, cantidad, unidad)

ingredientes
├── id, nombre, unidad_medida, stock_minimo, stock_actual

inventario_movimientos
├── id, ingrediente_id, tipo (entrada/salida/merma), cantidad, usuario_id, sucursal_id

proveedores
├── id, nombre, contacto, telefono, email, direccion
└── proveedor_productos (tabla pivote: proveedor_id, ingrediente_id, precio)

ordenes_compra
├── id, proveedor_id, sucursal_id, fecha, estado, total
└── orden_compra_detalles (tabla pivote: ingrediente_id, cantidad, precio_unitario)

mesas
├── id, sucursal_id, numero, capacidad, posicion_x, posicion_y, estado (libre/ocupada/reservada)

clientes
├── id, nombre, email, telefono, puntos, fecha_registro

pedidos
├── id, sucursal_id, mesa_id, cliente_id, usuario_id, tipo (mesa/llevar/delivery)
├── estado (nuevo/preparando/listo/entregado/cancelado), total, propina
└── pedido_detalles (tabla pivote: producto_id, cantidad, precio, modificadores)

pagos
├── id, pedido_id, metodo (efectivo/tarjeta/transferencia/wallet), monto, referencia

facturas
├── id, pedido_id, cliente_id, tipo (factura/boleta/nota_credito), serie, numero, total, xml, estado

caja_movimientos
├── id, sucursal_id, usuario_id, tipo (apertura/cierre/retiro/ingreso), monto, saldo_final

promociones
├── id, nombre, tipo (descuento/2x1/combohh), reglas (json), fecha_inicio, fecha_fin, sucursal_id

auditoria_logs
├── id, usuario_id, accion, modelo, modelo_id, datos_viejos (json), datos_nuevos (json), ip

notificaciones
├── id, tipo, titulo, mensaje, leido, usuario_id, sucursal_id
```

---

## API REST — Estructura de Rutas

```
# Autenticación
POST   /api/login
POST   /api/logout          (auth)
POST   /api/refresh         (auth)
GET    /api/me              (auth)

# Sucursales
GET    /api/sucursales
POST   /api/sucursales
GET    /api/sucursales/{id}
PUT    /api/sucursales/{id}
DELETE /api/sucursales/{id}

# Productos y Menú
GET    /api/categorias
GET    /api/productos
GET    /api/productos/{id}
POST   /api/productos
PUT    /api/productos/{id}

# Mesas
GET    /api/sucursales/{id}/mesas
POST   /api/mesas/{id}/ocupar
POST   /api/mesas/{id}/liberar

# Pedidos (POS)
POST   /api/pedidos
GET    /api/pedidos/{id}
PUT    /api/pedidos/{id}/estado
POST   /api/pedidos/{id}/pagar

# Cocina (KDS)
GET    /api/cocina/pedidos
PUT    /api/cocina/pedidos/{id}/preparar
PUT    /api/cocina/pedidos/{id}/listo

# Delivery
POST   /api/delivery/asignar
GET    /api/delivery/seguimiento/{id}

# Caja
POST   /api/caja/apertura
POST   /api/caja/cierre
POST   /api/caja/retiro
POST   /api/caja/ingreso
GET    /api/caja/movimientos

# Facturación
POST   /api/facturas
GET    /api/facturas/{id}
POST   /api/facturas/{id}/nota-credito

# Reportes
GET    /api/reportes/ventas
GET    /api/reportes/productos-mas-vendidos
GET    /api/reportes/utilidades
GET    /api/reportes/inventario

# Dashboard
GET    /api/dashboard/resumen
GET    /api/dashboard/ventas-hoy
GET    /api/dashboard/ocupacion

# Client
GET    /api/clientes
GET    /api/clientes/{id}/historial
POST   /api/clientes/{id}/puntos

# Auditoría
GET    /api/auditoria
```

---

## Panel Administrativo (Filament)

El panel está disponible en `/admin` con un tema personalizado:

- **Sidebar** con degradado oscuro (`#0f172a` → `#0c4a6e` → `#164e63`)
- **Transiciones animadas** en tablas (entrada escalonada de filas, hover con resalte)
- **Login** con imagen de fondo de restaurante
- **Ocultación completa** del sidebar con persistencia en localStorage

### Recursos Actuales

| Recurso      | Ícono                | Permisos                                        |
| ------------ | -------------------- | ----------------------------------------------- |
| Usuarios     | `heroicon-o-users`   | `user.list`, `user.create`, `user.edit`, `user.delete` |
| Roles        | `heroicon-o-shield-check` | `role.list`, `role.create`, `role.edit`, `role.delete` |
| Permisos     | `heroicon-o-key`     | `permission.list`, `permission.create`, `permission.edit`, `permission.delete` |

---

## Instalación y Configuración

```bash
# 1. Clonar el repositorio
git clone <repo-url> Restaurante
cd Restaurante

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias frontend
npm install

# 4. Configurar variables de entorno
cp .env.example .env
# Editar .env con los datos de conexión a la base de datos

# 5. Generar key de la aplicación
php artisan key:generate

# 6. Generar key JWT
php artisan jwt:secret

# 7. Ejecutar migraciones y seeders
php artisan migrate --seed

# 8. Compilar assets
npm run build

# 9. Iniciar servidor de desarrollo
php artisan serve
```

### Usuario por Defecto

Después de ejecutar los seeders, crear un usuario Super Admin:

```bash
php artisan tinker
> $user = new \App\Models\User;
> $user->name = 'Super Admin';
> $user->email = 'admin@restaurante.com';
> $user->password = bcrypt('password');
> $user->save();
> $user->assignRole('Super Admin');
```

---

## Ejecución de Pruebas

```bash
php artisan test
```

---

## Estructura del Proyecto (Laravel)

```
app/
├── Filament/             # Recursos y páginas del panel Filament
│   ├── Pages/
│   └── Resources/        # UserResource, RoleResource, PermissionResource
├── Http/
│   ├── Controllers/
│   │   └── Api/          # AuthController
│   └── ...
├── Models/               # Modelos Eloquent
├── Providers/
│   ├── Filament/
│   │   └── AdminPanelProvider.php
│   └── AppServiceProvider.php

database/
├── migrations/           # Esquema de base de datos
├── factories/            # Fábricas para tests
└── seeders/              # DatabaseSeeder, RolePermissionSeeder

resources/
├── css/
├── js/
└── views/
    └── filament/         # Personalización de vistas de Filament

routes/
├── api.php               # Rutas de la API REST
├── web.php               # Ruta principal
└── console.php           # Comandos personalizados
```

---

## Contribuir

1. Crear una rama desde `main`
2. Desarrollar siguiendo las convenciones de Laravel y PSR-12
3. Ejecutar `./vendor/bin/pint` para formatear el código
4. Crear PR describiendo los cambios y módulo afectado
