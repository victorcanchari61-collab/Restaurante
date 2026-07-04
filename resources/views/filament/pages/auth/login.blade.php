<x-filament-panels::page.simple>
    {{ $this->content }}
</x-filament-panels::page.simple>

<style>
    .fi-simple-layout {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1920&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
    }

    .fi-simple-layout::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.85), rgba(15, 23, 42, 0.8));
        z-index: 0;
    }

    .fi-simple-main-ctn {
        position: relative;
        z-index: 1;
    }

    .fi-simple-main {
        backdrop-filter: blur(16px);
        background: rgba(255, 255, 255, 0.95) !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .fi-simple-layout-header {
        position: relative;
        z-index: 1;
    }

    .dark .fi-simple-main {
        background: rgba(15, 23, 42, 0.95) !important;
        border-color: rgba(255, 255, 255, 0.1);
    }
</style>
