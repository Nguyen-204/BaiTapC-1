@extends('layouts.admin')
@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-phone"></i> Quản lý sản phẩm</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Thêm sản
        phẩm</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Hình</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Kho</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>
                        @if($p->image)
                        <img src="{{ asset('storage/' . $p->image) }}" width="50" height="50" class="rounded"
                            style="object-fit:contain;background:#f8fbff;padding:4px">
                        @else
                        <div class="product-img-placeholder rounded"
                            style="width:50px;height:50px;min-height:auto;font-size:1rem"><i class="bi bi-phone"></i>
                        </div>
                        @endif
                    </td>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $p->category->name ?? 'N/A' }}</span></td>
                    <td class="text-danger fw-bold">{{ number_format($p->price) }} ₫</td>
                    <td>{{ $p->stock }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.edit', $p->id) }}" class="btn btn-warning btn-sm"><i
                                    class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.products.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Xóa sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">Chưa có sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">{{ $products->links('pagination::bootstrap-5') }}</div>
@endsection
