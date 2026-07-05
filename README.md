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

### 1. Gestión de Restaurantes / Sucursales
Registro y configuración de sucursales: nombre, dirección, teléfono, horarios, impuestos locales, estado (activo/inactivo) y parámetros propios de cada local.
- **Configuración General** — Datos fiscales, moneda local y preferencias regionales
- **Horarios** — Definición de turnos, días laborales y excepciones
- **Ubicación** — Dirección, coordenadas, zonas de cobertura
- **Multimedia** — Logotipo, fotos del local y galería

### 2. Usuarios y Roles
Administración de usuarios con roles y permisos granulares. Roles predefinidos: Super Admin, Admin, Cajero, Cocinero, Mesero. Cada usuario puede pertenecer a una o más sucursales.
- **Usuarios** — CRUD completo, autenticación y perfil
- **Roles** — Creación y edición de roles con permisos agrupados
- **Permisos** — Permisos individuales granulares por acción y recurso
- **Asignación por Sucursal** — Vinculación usuario-sucursal con rol específico

### 3. Punto de Venta (POS)
Creación de pedidos, cobro, división de cuentas, descuentos, propinas y facturación. Flujo rápido para atención en mostrador o mesa.
- **Nuevo Pedido** — Selección rápida de productos, cantidades y notas
- **Cobro** — Consolidación de cuenta y selección de método de pago
- **División de Cuentas** — Reparto equitativo o personalizado entre comensales
- **Descuentos y Propinas** — Aplicación de descuentos, propina sugerida o personalizada
- **Cierre** — Facturación o ticket final con opciones de impresión

### 4. Gestión de Mesas
Plano interactivo del restaurante, control de ocupación, reservas, cambio de mesas y tiempo de estancia.
- **Plano Interactivo** — Vista gráfica con arrastrar y soltar para asignación
- **Ocupación** — Control de estado (libre, ocupada, reservada, sucia)
- **Reservas** — Agenda de reservas con datos del cliente y hora
- **Historial** — Tiempo de estancia, facturación acumulada y rotación

### 5. Menú y Productos
Categorías, platos, bebidas, combos, modificadores (ej. ingredientes extras), imágenes y precios diferenciados por sucursal.
- **Categorías** — Agrupación jerárquica de productos del menú
- **Productos** — CRUD con nombre, descripción, precio, imágenes y tipo
- **Modificadores** — Opciones extras, ingredientes adicionales y personalización
- **Precios por Sucursal** — Precios diferenciados y disponibilidad por local
- **Combos** — Agrupación de productos con precio especial

### 6. Inventario
Control de ingredientes y materias primas, existencias mínimas y máximas, mermas, ajustes y movimientos de inventario.
- **Ingredientes** — Catálogo de materias primas con unidad de medida
- **Existencias** — Stock actual, mínimo, máximo y alertas de reabastecimiento
- **Movimientos** — Entradas, salidas, mermas y ajustes con trazabilidad
- **Transferencias** — Traslado de existencias entre sucursales

### 7. Recetas
Vinculación de ingredientes a cada producto del menú con cantidades exactas. Cálculo de costo unitario y descuento automático del inventario al registrar una venta.
- **Composición** — Asignación de ingredientes con cantidades exactas por producto
- **Costo Unitario** — Cálculo automático del costo de producción
- **Descuento Automático** — Baja de inventario al confirmar pedidos
- **Escalado** — Ajuste de cantidades para producción por lote

### 8. Compras
Órdenes de compra a proveedores, recepción de productos, control de precios y abastecimiento de inventario.
- **Órdenes de Compra** — Creación, autorización y envío a proveedores
- **Recepción** — Ingreso de productos y actualización automática de inventario
- **Historial** — Precios históricos, tiempos de entrega y evaluación

### 9. Proveedores
Registro de proveedores, contactos, productos que suministran, historial de compras, pagos y evaluación.
- **Registro** — Datos fiscales, contacto y clasificación
- **Productos Suministrados** — Catálogo de insumos por proveedor
- **Evaluación** — Calificación por cumplimiento, calidad y precio
- **Pagos** — Cuentas por pagar y registro de transacciones

### 10. Clientes (CRM)
Historial de compras, acumulación y canje de puntos, promociones personalizadas, datos de contacto y preferencias.
- **Perfil** — Datos de contacto, preferencias y segmentación
- **Historial** — Compras realizadas, tickets y productos favoritos
- **Puntos** — Acumulación, canje y niveles de fidelización
- **Segmentación** — Grupos para campañas promocionales dirigidas

### 11. Pedidos
Gestión de pedidos en todas sus modalidades: consumo en mesa, para llevar, delivery y pedidos anticipados.
- **Mesa** — Pedidos asociados a comensales con control de tiempos
- **Para Llevar** — Pedidos empaquetados con tiempo de preparación
- **Delivery** — Pedidos con dirección de entrega y repartidor asignado
- **Anticipados** — Pedidos programados para fecha y hora futura

### 12. Delivery
Asignación de repartidores, seguimiento en tiempo real, zonas de entrega, tarifas dinámicas y cálculo de tiempo estimado.
- **Repartidores** — Registro, disponibilidad y zona de cobertura
- **Zonas** — Geocercas con tarifas y tiempos estimados por área
- **Tarifas** — Costo dinámico por distancia, hora y demanda
- **Seguimiento** — Mapa en tiempo real con estado del pedido

### 13. Cocina (KDS — Kitchen Display System)
Pantalla dedicada para cocina donde los pedidos entrantes se muestran en tiempo real. Los cocineros marcan platillos como "en preparación" y "listo".
- **Pantalla de Pedidos** — Visualización en tiempo real de pedidos entrantes
- **Estados** — Flujo: nuevo → en preparación → listo → entregado
- **Tiempos** — Control de tiempo de preparación por platillo
- **Notificaciones** — Alertas sonoras y visuales para pedidos urgentes

### 14. Caja
Apertura y cierre de caja, arqueos, retiros e ingresos de efectivo, control de fondo fijo por turno y sucursal.
- **Apertura** — Registro de fondo inicial por turno y usuario
- **Arqueo** — Conteo de efectivo y diferencia con el sistema
- **Movimientos** — Retiros e ingresos durante el turno
- **Cierre** — Corte de caja con resumen de transacciones y depósito

### 15. Facturación
Generación de facturas, boletas, notas de crédito y débito. Integración con autoridades tributarias (SAT/SUNAT/SII según el país).
- **Facturas** — Emisión de comprobantes fiscales con datos del cliente
- **Boletas** — Comprobante simplificado para consumidor final
- **Notas de Crédito/Débito** — Anulación y corrección de comprobantes
- **Tributación** — Integración con APIs de entidades fiscales

### 16. Pagos
Múltiples métodos de pago: efectivo, tarjeta (débito/crédito), transferencias, billeteras digitales y pagos mixtos (división de cuenta con distintos métodos).
- **Efectivo** — Cobro en efectivo con cálculo de vuelto
- **Tarjeta** — Integración con terminales POS y pasarelas de pago
- **Transferencias** — Depósitos bancarios y transferencias electrónicas
- **Billeteras Digitales** — Mercado Pago, PayPal, Yape, Plin, etc.
- **Pago Mixto** — División de cuenta con combinación de métodos

### 17. Promociones
Descuentos por volumen, cupones, combos promocionales, happy hour, programas de fidelización y reglas configurables por sucursal.
- **Cupones** — Códigos promocionales con condiciones y vigencia
- **Combos Promocionales** — Paquetes con precio especial por tiempo limitado
- **Happy Hour** — Descuentos programados en franja horaria
- **Fidelización** — Programa de recompensas por frecuencia de consumo

### 18. Reportes
Reportes de ventas por período, utilidades por producto, productos más vendidos, movimientos de inventario, desempeño por sucursal y cierres de caja.
- **Ventas** — Ingresos por período, sucursal y método de pago
- **Productos** — Ranking de más vendidos, rentabilidad y rotación
- **Inventario** — Movimientos, mermas y proyección de consumo
- **Caja** — Corte por turno, diferencias y depósitos
- **Comparativo** — Desempeño entre sucursales y períodos

### 19. Dashboard Gerencial
Indicadores clave en tiempo real: ventas del día, ocupación de mesas, pedidos en cocina, ticket promedio y comparativas entre sucursales.
- **Resumen en Vivo** — Ventas, pedidos y ocupación actualizados al instante
- **Comparativas** — KPI side-by-side entre sucursales
- **Alertas** — Indicadores fuera de rango con notificaciones visuales
- **Metas** — Progreso hacia objetivos diarios, semanales y mensuales

### 20. Configuración General
Parámetros globales del sistema: impuestos (IVA/IGV), moneda, formatos de impresión, configuración de impresoras térmicas, plantillas de tickets.
- **Impuestos** — Tasas de IVA/IGV, retenciones y percepciones
- **Moneda** — Moneda local, símbolo, formato y decimales
- **Impresión** — Configuración de impresoras térmicas y formatos de ticket
- **Plantillas** — Personalización de tickets, facturas y reportes

### 21. Auditoría
Registro detallado de todas las acciones realizadas por los usuarios: creación, modificación y eliminación de registros con fecha, usuario y datos anteriores.
- **Traza** — Registro cronológico de acciones por usuario y modelo
- **Detalle** — Antes/después de cada modificación con datos completos
- **Exportación** — Descarga de logs por período y filtro
- **Visualización** — Panel de consulta con búsqueda y filtros avanzados

### 22. Notificaciones
Alertas automáticas: inventario bajo, pedidos nuevos en cocina, compras por recibir, cierres de caja pendientes y vencimiento de productos.
- **Alertas** — Notificaciones push, correo o pantalla según criticidad
- **Canales** — Correo, notificación en app, pantalla KDS, SMS
- **Suscripciones** — Configuración por usuario y tipo de evento
- **Historial** — Registro de notificaciones enviadas con estado de lectura

### Módulos Adicionales (Recomendados)

- Reservas en línea (widget web)
- Programa de fidelización (puntos y niveles)
- Encuestas de satisfacción
- Gestión de empleados y turnos
- Control de asistencia (reloj checador)
- Integración con plataformas de delivery (Uber Eats, Rappi, etc.)
- Aplicación móvil para meseros (toma de pedidos)
- App para clientes (pedidos, reservas, historial)
- Business Intelligence (BI) con análisis predictivo

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
