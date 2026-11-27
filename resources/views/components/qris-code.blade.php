@props(['seed' => 'KANTINPAPA', 'size' => 192])

@php
    $hash = hash('sha256', $seed);
    $grid = 21;
    $cells = [];
    for ($r = 0; $r < $grid; $r++) {
        for ($c = 0; $c < $grid; $c++) {
            $inTopLeft = $r < 7 && $c < 7;
            $inTopRight = $r < 7 && $c >= $grid - 7;
            $inBottomLeft = $r >= $grid - 7 && $c < 7;
            $inCenterLogo = $r >= 8 && $r <= 12 && $c >= 8 && $c <= 12;

            if ($inTopLeft || $inTopRight || $inBottomLeft || $inCenterLogo) {
                continue;
            }

            $idx = ($r * $grid + $c) % 64;
            $bit = hexdec($hash[$idx]) % 2 === 1;
            if ($bit) {
                $cells[] = [$c, $r];
            }
        }
    }
@endphp

<div class="relative inline-flex items-center justify-center bg-white border border-neutral-300 rounded-2xl p-3 shadow-xs">
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 21 21" shape-rendering="crispEdges" aria-label="QRIS Code">
        <rect width="21" height="21" fill="#FFFFFF" />
        {{-- Top-Left Finder --}}
        <rect x="0" y="0" width="7" height="7" fill="#171717" rx="0.5" />
        <rect x="1" y="1" width="5" height="5" fill="#FFFFFF" />
        <rect x="2" y="2" width="3" height="3" fill="#171717" />
        {{-- Top-Right Finder --}}
        <rect x="14" y="0" width="7" height="7" fill="#171717" rx="0.5" />
        <rect x="15" y="1" width="5" height="5" fill="#FFFFFF" />
        <rect x="16" y="2" width="3" height="3" fill="#171717" />
        {{-- Bottom-Left Finder --}}
        <rect x="0" y="14" width="7" height="7" fill="#171717" rx="0.5" />
        <rect x="1" y="15" width="5" height="5" fill="#FFFFFF" />
        <rect x="2" y="16" width="3" height="3" fill="#171717" />

        @foreach ($cells as [$cx, $cy])
            <rect x="{{ $cx }}" y="{{ $cy }}" width="1" height="1" fill="#171717" />
        @endforeach
    </svg>
    <div class="absolute w-10 h-10 rounded-lg bg-red-600 text-white font-bold text-xs flex items-center justify-center shadow ring-2 ring-white">
        KP
    </div>
</div>
