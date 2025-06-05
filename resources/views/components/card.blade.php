@props(['bgColor' => 'rgba(132, 221, 99, 1)'])

<div class="card rounded-4 border-0 shadow-sm">
    <div class="card-body d-flex flex-wrap align-items-center px-4 gap-3">
        @isset($icon)
            <div class="icon-container rounded-3 d-flex align-items-center justify-content-center"
                 style="min-width: 50px; min-height: 50px; width: 15%; max-width: 70px; background-color: '{{ $bgColor }}';">
                {{ $icon }}
            </div>
        @endisset
        <div class="flex-grow-1">
            {{ $slot }}
        </div>
    </div>
</div>
