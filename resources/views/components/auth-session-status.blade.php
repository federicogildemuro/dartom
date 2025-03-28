@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'text-yellow']) }}>
        {{ $status }}
    </div>
@endif
