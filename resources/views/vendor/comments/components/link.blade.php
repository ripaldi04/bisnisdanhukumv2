@props(['route' => '#', 'type' => 'navigate'])

@if ($type === 'navigate')
    <a wire:navigate href="{{ $route }}"
        {{ $attributes->merge(['class' => 'font-medium text-yellow-600 dark:text-yellow-500 hover:underline transition']) }}>
        {{ $slot }}
    </a>
@elseif ($type === 'a')
    <a href="{{ $route }}"
        {{ $attributes->merge(['class' => 'font-medium text-yellow-600 dark:text-yellow-500 hover:underline transition']) }}>
        {{ $slot }}
    </a>
@else
    <span
        {{ $attributes->merge(['class' => 'inline-block cursor-pointer font-medium text-yellow-600 dark:text-yellow-500 border-transparent border-b hover:border-yellow-600 transition']) }}>
        {{ $slot }}
    </span>
@endif
