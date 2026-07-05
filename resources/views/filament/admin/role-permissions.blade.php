@php
    $grupos = collect($permissions)->groupBy(fn ($p) => str($p)->before('.')->toString())->sortKeys();
@endphp

<div style="display: flex; flex-direction: column; gap: 1rem;">
    @forelse ($grupos as $grupo => $perms)
        <div>
            <div style="font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.6; margin-bottom: 0.4rem;">
                {{ ucfirst($grupo) }}
            </div>
            <div style="display: flex; flex-wrap: wrap; gap: 0.375rem;">
                @foreach ($perms as $permiso)
                    <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.72rem; font-weight: 500; background: rgba(14, 165, 233, 0.12); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.25);">
                        {{ $permiso }}
                    </span>
                @endforeach
            </div>
        </div>
    @empty
        <p style="opacity: 0.6; font-size: 0.85rem;">Este rol no tiene permisos asignados.</p>
    @endforelse
</div>
