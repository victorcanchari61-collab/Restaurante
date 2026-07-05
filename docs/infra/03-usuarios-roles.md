# Usuarios y Roles

## Qué hace
Administración de cuentas, roles y permisos granulares del sistema.

## Lógica
- Roles predefinidos: Super Admin (todos), Admin, Cajero, Cocinero, Mesero.
- CRUD usuarios con asignación de roles y sucursal.
- CRUD roles con asignación masiva de permisos.
- **Regla:** no eliminar/desactivar al único Super Admin.
- **Regla:** el rol Super Admin siempre tiene todos los permisos.

## Permisos
`user.*`, `role.*`, `permission.*`
