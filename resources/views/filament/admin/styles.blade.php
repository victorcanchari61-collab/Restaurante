<script>
    // Tercer estado del sidebar: oculto por completo (persistido entre páginas).
    // Se aplica sobre <html> antes de renderizar el body para evitar parpadeo.
    (function () {
        if (localStorage.getItem('appSidebarHidden') === '1') {
            document.documentElement.classList.add('app-sidebar-hidden');
        }

        window.toggleAppSidebar = function () {
            const hidden = document.documentElement.classList.toggle('app-sidebar-hidden');
            localStorage.setItem('appSidebarHidden', hidden ? '1' : '0');
        };
    })();
</script>
<style>
    /* ============ SIDEBAR ============ */
    .fi-sidebar {
        background: linear-gradient(180deg, #0f172a 0%, #0c4a6e 60%, #164e63 100%) !important;
        border-right: 1px solid rgba(125, 211, 252, 0.15);
        /* Tailwind v4 usa las propiedades `translate` y `width`; animarlas da la transición de contraer */
        transition: translate 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* Filament fija el sidebar a top:4rem (alto por defecto del navbar);
       como el navbar se comprimió a 2.75rem, hay que ajustar para no dejar hueco */
    @media (min-width: 64rem) {
        .fi-body-has-topbar .fi-sidebar {
            top: 2.75rem !important;
            height: calc(100dvh - 2.75rem) !important;
        }
    }

    /* Sidebar contraído (solo iconos): sin desplazamiento lateral en hover */
    .fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-btn:hover {
        transform: none;
    }

    /* ============ ESTADO OCULTO (tercer estado, solo escritorio) ============ */
    @media (min-width: 64rem) {
        html.app-sidebar-hidden .fi-sidebar {
            width: 0 !important;
            min-width: 0 !important;
            translate: -100% 0;
            border-right: none !important;
            overflow: hidden;
        }
    }

    /* Botón mostrar/ocultar del navbar */
    .app-sidebar-hide-btn {
        display: none;
        align-items: center;
        justify-content: center;
        padding: 0.375rem;
        border-radius: 0.5rem;
        color: #cbd5e1;
        cursor: pointer;
        transition: transform 0.25s ease, background-color 0.2s ease, color 0.2s ease;
    }

    @media (min-width: 64rem) {
        .app-sidebar-hide-btn {
            display: flex;
        }
    }

    .app-sidebar-hide-btn:hover {
        transform: scale(1.15);
        background: rgba(125, 211, 252, 0.12);
        color: #ffffff;
    }

    /* Alternar icono según el estado */
    .app-sidebar-hide-btn .app-sidebar-icon-show {
        display: none;
    }

    html.app-sidebar-hidden .app-sidebar-hide-btn .app-sidebar-icon-hide {
        display: none;
    }

    html.app-sidebar-hidden .app-sidebar-hide-btn .app-sidebar-icon-show {
        display: block;
    }

    .fi-sidebar .fi-sidebar-header,
    .fi-sidebar .fi-sidebar-item,
    .fi-sidebar .fi-sidebar-group {
        --sidebar-bg: transparent !important;
    }

    .fi-sidebar .fi-sidebar-header {
        background: transparent !important;
        border-bottom: 1px solid rgba(125, 211, 252, 0.12);
    }

    .fi-sidebar nav {
        padding-top: 0.75rem !important;
    }

    /* Ítems: texto e iconos claros sobre el fondo oscuro */
    .fi-sidebar .fi-sidebar-item-btn {
        border-radius: 0.5rem;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .fi-sidebar .fi-sidebar-item-label {
        color: #cbd5e1 !important;
        font-size: 0.78rem !important;
        transition: color 0.2s ease;
    }

    .fi-sidebar .fi-sidebar-item-icon {
        color: #7dd3fc !important;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    /* Hover: deslizamiento suave */
    .fi-sidebar .fi-sidebar-item-btn:hover {
        background: rgba(125, 211, 252, 0.1) !important;
        transform: translateX(4px);
    }

    .fi-sidebar .fi-sidebar-item-btn:hover .fi-sidebar-item-label {
        color: #f0f9ff !important;
    }

    .fi-sidebar .fi-sidebar-item-btn:hover .fi-sidebar-item-icon {
        transform: scale(1.12);
    }

    /* Ítem activo */
    .fi-sidebar .fi-sidebar-item.fi-active .fi-sidebar-item-btn {
        background: rgba(56, 189, 248, 0.18) !important;
        box-shadow: inset 3px 0 0 #38bdf8;
    }

    .fi-sidebar .fi-sidebar-item.fi-active .fi-sidebar-item-label {
        color: #ffffff !important;
        font-weight: 600;
    }

    .fi-sidebar .fi-sidebar-item.fi-active .fi-sidebar-item-icon {
        color: #38bdf8 !important;
    }

    /* Etiquetas de grupo */
    .fi-sidebar .fi-sidebar-group-label {
        color: #7dd3fc !important;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-size: 0.68rem !important;
    }

    .fi-sidebar .fi-sidebar-group-collapse-btn {
        color: #7dd3fc !important;
    }

    /* Scrollbar del sidebar */
    .fi-sidebar nav::-webkit-scrollbar {
        width: 5px;
    }

    .fi-sidebar nav::-webkit-scrollbar-thumb {
        background: rgba(125, 211, 252, 0.25);
        border-radius: 9999px;
    }

    /* ============ TOPBAR / NAVBAR ============ */
    /* Mismo fondo que el sidebar */
    .fi-topbar-ctn,
    .fi-topbar {
        background: #0f172a !important;
    }

    .fi-topbar {
        height: 2.75rem !important;
        min-height: 2.75rem !important;
        padding-top: 0.25rem !important;
        padding-bottom: 0.25rem !important;
        background: linear-gradient(90deg, #0f172a 0%, #0c4a6e 100%) !important;
        border-bottom: 1px solid rgba(125, 211, 252, 0.15);
        box-shadow: 0 1px 8px rgba(2, 6, 23, 0.3);
    }

    .fi-topbar > .fi-topbar-inner {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    /* Iconos y texto claros en el navbar oscuro */
    .fi-topbar .fi-icon-btn {
        color: #cbd5e1 !important;
    }

    .fi-topbar .fi-topbar-item-label,
    .fi-topbar .fi-breadcrumbs-item,
    .fi-topbar .fi-breadcrumbs-item-label {
        color: #e2e8f0 !important;
    }

    /* Botón de mostrar/ocultar sidebar (icono en el navbar) */
    .fi-topbar-open-sidebar-btn,
    .fi-topbar-close-sidebar-btn,
    .fi-layout-sidebar-toggle-btn,
    .fi-topbar .fi-icon-btn {
        transition: transform 0.25s ease, background-color 0.2s ease, color 0.2s ease;
        border-radius: 0.5rem;
    }

    .fi-topbar-open-sidebar-btn:hover,
    .fi-topbar-close-sidebar-btn:hover,
    .fi-layout-sidebar-toggle-btn:hover,
    .fi-topbar .fi-icon-btn:hover {
        transform: scale(1.15);
        background: rgba(125, 211, 252, 0.12) !important;
        color: #ffffff !important;
    }

    /* Logo contenido dentro del navbar/sidebar */
    .fi-logo {
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* ============ TABLAS ============ */
    @keyframes fi-table-in {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: none;
        }
    }

    @keyframes fi-row-in {
        from {
            opacity: 0;
            transform: translateY(6px);
        }
        to {
            opacity: 1;
            transform: none;
        }
    }

    .fi-ta {
        animation: fi-table-in 0.3s ease both;
    }

    /* Entrada escalonada de filas */
    .fi-ta-table .fi-ta-row {
        animation: fi-row-in 0.35s ease both;
    }

    .fi-ta-table .fi-ta-row:nth-child(1) { animation-delay: 0.03s; }
    .fi-ta-table .fi-ta-row:nth-child(2) { animation-delay: 0.06s; }
    .fi-ta-table .fi-ta-row:nth-child(3) { animation-delay: 0.09s; }
    .fi-ta-table .fi-ta-row:nth-child(4) { animation-delay: 0.12s; }
    .fi-ta-table .fi-ta-row:nth-child(5) { animation-delay: 0.15s; }
    .fi-ta-table .fi-ta-row:nth-child(6) { animation-delay: 0.18s; }
    .fi-ta-table .fi-ta-row:nth-child(7) { animation-delay: 0.21s; }
    .fi-ta-table .fi-ta-row:nth-child(8) { animation-delay: 0.24s; }
    .fi-ta-table .fi-ta-row:nth-child(9) { animation-delay: 0.27s; }
    .fi-ta-table .fi-ta-row:nth-child(n + 10) { animation-delay: 0.3s; }

    /* Hover de filas */
    .fi-ta-table .fi-ta-row {
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .fi-ta-table .fi-ta-row:hover {
        background: rgba(14, 165, 233, 0.06) !important;
        box-shadow: inset 3px 0 0 #38bdf8;
    }

    .dark .fi-ta-table .fi-ta-row:hover {
        background: rgba(56, 189, 248, 0.08) !important;
    }

    /* Encabezados de tabla */
    .fi-ta-header-cell {
        text-transform: uppercase;
        font-size: 0.7rem !important;
        letter-spacing: 0.05em;
    }

    /* ============ TOOLBAR DE TABLA (filtros y gestor de columnas) ============ */
    /* Iconos de embudo (filtros) y de columnas: resalte al pasar el mouse */
    .fi-ta-header-toolbar .fi-icon-btn {
        transition: transform 0.2s ease, background-color 0.2s ease, color 0.2s ease;
        border-radius: 0.5rem;
    }

    .fi-ta-header-toolbar .fi-icon-btn:hover {
        transform: scale(1.12);
        background: rgba(14, 165, 233, 0.1);
        color: #0284c7;
    }

    /* Entrada animada de los dropdowns (filtros, gestor de columnas, acciones) */
    @keyframes fi-dropdown-in {
        from {
            opacity: 0;
            transform: translateY(-6px) scale(0.97);
        }
        to {
            opacity: 1;
            transform: none;
        }
    }

    .fi-dropdown-panel {
        animation: fi-dropdown-in 0.18s ease both;
        transform-origin: top;
    }

    /* Filas del gestor de columnas (mostrar/ocultar/arrastrar) */
    .fi-ta-col-manager-dropdown label,
    .fi-ta-col-manager-dropdown [x-sortable-item] {
        border-radius: 0.375rem;
        transition: background-color 0.15s ease;
    }

    .fi-ta-col-manager-dropdown label:hover,
    .fi-ta-col-manager-dropdown [x-sortable-item]:hover {
        background: rgba(14, 165, 233, 0.08);
    }

    /* Elemento arrastrándose en el reordenamiento de columnas */
    .fi-sortable-ghost {
        opacity: 0.4;
        background: rgba(14, 165, 233, 0.15) !important;
        border-radius: 0.375rem;
    }

    /* Transición al ocultar/mostrar columnas (la tabla se re-renderiza) */
    .fi-ta-cell {
        transition: opacity 0.2s ease;
    }
</style>
