@props(['href', 'target' => null, 'rel' => null, 'ariaLabel' => null])

<a href="{{ $href }}" @if ($target) target="{{ $target }}" @endif
    @if ($rel) rel="{{ $rel }}" @endif
    @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
    class="hover:text-yellow transition duration-150 ease-in-out">
    {{ $slot }}
</a>
