@props([
    'url'       => null,
    'text'      => null,
    'htmlType'  => 'button',
])

@php
    $classes = ($attributes->has('disabled'))
        ? "btn block w-full text-center bg-blue-100 text-white font-semibold py-2 px-4 rounded"
        : "btn block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded cursor-pointer"
@endphp

@if ($url)
    <a
        href="{{ $url }}"
        {{ $attributes
            ->class($classes)
        }}
    >
        {{ $slot->isEmpty() ? $text : $slot }}
    </a>
@else
    <button
        {{ $attributes
            ->class($classes)
        }}
        type="{{ $htmlType }}"
    >
        {{ $slot->isEmpty() ? $text : $slot }}
    </button>
@endif
