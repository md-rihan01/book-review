@props([
    'label' => '',
    'sort' => '',
    'currentSort' => '',
    'currentDirection' => '',
])

@php
    $isActive = $currentSort === $sort;
    $nextDirection = $isActive && $currentDirection === 'asc' ? 'desc' : 'asc';
    $icon = $isActive ? ($currentDirection === 'asc' ? '↑' : '↓') : '↕';
    $ariaLabel = $isActive && $currentDirection === 'asc'
        ? "Sort by {$label} descending"
        : "Sort by {$label} ascending";

    $query = array_merge(request()->query(), [
        'sort' => $sort,
        'direction' => $nextDirection,
        'page' => 1,
    ]);
    $url = request()->url() . '?' . http_build_query($query);
@endphp

<a href="{{ $url }}"
   class="sortable-header {{ $isActive ? 'active' : '' }}"
   aria-label="{{ $ariaLabel }}">
    {{ $label }}
    <span class="sort-icon">{{ $icon }}</span>
</a>
