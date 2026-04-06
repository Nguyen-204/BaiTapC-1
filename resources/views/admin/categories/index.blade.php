@extends('layouts.admin')
@section('title', 'Quản lý danh mục')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-folder"></i> Quản lý danh mục</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Thêm danh
        mục</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Số sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td><strong>{{ $cat->name }}</strong></td>
                    <td class="text-muted">{{ $cat->slug }}</td>
                    <td><span class="badge bg-info">{{ $cat->products_count }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-warning btn-sm"><i
                                    class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                onsubmit="return confirm('Xóa danh mục này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">Chưa có danh mục nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection