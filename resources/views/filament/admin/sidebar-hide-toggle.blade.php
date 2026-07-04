<button
    type="button"
    onclick="window.toggleAppSidebar()"
    class="app-sidebar-hide-btn"
    title="Mostrar / ocultar menú"
>
    {{-- Icono « : ocultar (visible cuando el sidebar se ve) --}}
    <svg class="app-sidebar-icon-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
        <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
    </svg>

    {{-- Icono ≡ : mostrar (visible cuando el sidebar está oculto) --}}
    <svg class="app-sidebar-icon-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="22" height="22">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
</button>
