@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="page-header">
        <h2>Users</h2>
        <a href="{{ route('admin.users.create') }}" class="btn-admin-primary">
            <i class="bi bi-person-plus"></i> Add New User
        </a>
    </div>

    <div class="form-card mb-4">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control form-control-sm"
                    placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="author" {{ request('role') === 'author' ? 'selected' : '' }}>Author</option>
                    <option value="subscriber" {{ request('role') === 'subscriber' ? 'selected' : '' }}>Subscriber</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-admin-primary btn-sm w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.users.index') }}" class="btn-admin-secondary btn-sm w-100 d-block text-center">Clear</a>
            </div>
            <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
        </form>
    </div>

    <form method="POST" action="{{ route('admin.users.bulk') }}" id="bulk-form">
        @csrf
        <x-bulk-actions :actions="['delete' => 'Delete Selected']" />

        <div class="admin-table-wrapper">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th class="bulk-checkbox-column"><input type="checkbox" class="bulk-select-all" aria-label="Select all"></th>
                        <th class="sno-column">S.No.</th>
                        <th><x-sortable-header label="Name" sort="name" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Email" sort="email" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Role" sort="role" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th><x-sortable-header label="Created" sort="created_at" :currentSort="request('sort')" :currentDirection="request('direction')" /></th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="bulk-checkbox-column">
                                <input type="checkbox" name="selected_ids[]" value="{{ $user->id }}"
                                    class="bulk-row-checkbox" aria-label="Select {{ $user->name }}">
                            </td>
                            <td class="sno-column">{{ $users->firstItem() + $loop->index }}</td>
                            <td class="fw-medium">{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td><span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                            <td class="text-muted small">{{ $user->created_at->format('M j, Y') }}</td>
                            <td class="actions-column">
                                <div class="action-group" style="justify-content:flex-end;">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="action-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    @if($user->id !== Auth::user()->id)
                                        <button type="button" class="action-delete"
                                            onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}', 'Are you sure you want to delete user &quot;{{ $user->name }}&quot;?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <x-bulk-actions :actions="['delete' => 'Delete Selected']" :below="true" />
        @endif

        <div class="admin-pagination">
            {{ $users->withQueryString()->links() }}
        </div>
    </form>
@endsection
