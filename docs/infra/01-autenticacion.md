# Autenticación (JWT)

## Qué hace
Login por email/contraseña que emite token JWT; renovación y cierre de sesión.

## Lógica
- `POST /api/login` → valida credenciales → token JWT con TTL configurable.
- `GET /api/me` → usuario autenticado con roles y permisos.
- `POST /api/refresh` y `POST /api/logout`.
- Los permisos se resuelven contra el guard `web` aunque la auth sea JWT.

## Archivos clave
`AuthController`, `AuthService`, `LoginRequest`, `UserResource`
