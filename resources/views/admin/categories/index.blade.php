@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Categories</h2>
    
    @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
    <a href="{{ route('admin.categories.create') }}" class="btn btn-gradient rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-circle me-2"></i> Add Category
    </a>
    @endif
</div>

<div class="glass-card mb-4">
    <div class="p-4 border-bottom border-light d-flex justify-content-between align-items-center bg-light bg-opacity-50">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex gap-2 w-100" style="max-width: 400px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search categories..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="20%">Name</th>
                    <th width="35%">Description</th>
                    <th width="15%">Products</th>
                    <th width="10%">Status</th>
                    <th width="15%" class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories ?? [] as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="fw-semibold">{{ $category->name }}</td>
                    <td class="text-truncate" style="max-width: 250px;">{{ $category->description ?? '-' }}</td>
                    <td>
                        <span class="badge bg-secondary badge-custom">{{ $category->products_count ?? 0 }} Items</span>
                    </td>
                    <td>
                        @if($category->is_active ?? true)
                            <span class="badge bg-success badge-custom">Active</span>
                        @else
                            <span class="badge bg-danger badge-custom">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        @if(!(method_exists(auth()->user(), 'isAuditor') ? auth()->user()->isAuditor() : auth()->user()->role === 'auditor'))
                        <div class="btn-group">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-tags fs-1 d-block mb-3"></i>
                            <p class="mb-0">No categories found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($categories) && method_exists($categories, 'links'))
    <div class="p-3 border-top border-light d-flex justify-content-end">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
