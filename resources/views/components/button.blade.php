@props([
    'route' => '#',
    'label' => 'Back',
    'type' => 'secondary'
])

<a href="{{ $route }}" class="btn btn-{{ $type }}">
    {{ $label }}
</a>