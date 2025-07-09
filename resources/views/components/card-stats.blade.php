@props(['label', 'value', 'color' => 'primary', 'icon' => 'fa-info-circle'])

@php
    $colorClass = $color === 'indigo' ? 'custom-indigo' : $color;
@endphp

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-{{ $colorClass }} shadow-sm h-100 py-2 transition">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <div class="text-xs font-weight-bold text-{{ $colorClass }} text-uppercase mb-1">{{ $label }}
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $value }}</div>
            </div>
            <i class="fas {{ $icon }} fa-2x text-gray-300"></i>
        </div>
    </div>
</div>
