# Configuración General

## Qué hace
Parámetros globales del sistema que aplican a todas las sucursales.

## Lógica
- Almacenados en tabla `configuraciones` (clave-valor).
- Impuestos: tasa de IVA/IGV, retenciones, percepciones.
- Moneda: símbolo, código ISO, formato, decimales.
- Impresión: tipo de impresora, ancho de ticket, formato.
- Plantillas: personalización de tickets, facturas, reportes.
- Solo accesible para Super Admin y Admin.
- **Regla:** cambios en impuestos afectan solo pedidos nuevos.
