@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-3 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 bg-gray-200 dark:bg-gray-700 rounded-md'
            : 'block px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

