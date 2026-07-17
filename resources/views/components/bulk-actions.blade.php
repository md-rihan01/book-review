@props([
    'actions' => [],
    'below' => false,
])

@if(count($actions) > 0)
    <div class="bulk-actions-bar {{ $below ? 'below' : '' }}">
        <select name="bulk_action" class="bulk-action-select" aria-label="Bulk actions">
            <option value="">Bulk Actions</option>
            @foreach($actions as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="bulk-apply-btn" onclick="return handleBulkAction(this)">
            Apply
        </button>
    </div>
@endif
