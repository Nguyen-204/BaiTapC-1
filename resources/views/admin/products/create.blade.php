@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')

@section('content')
<h2 class="mb-4"><i class="bi bi-plus-lg"></i> Thêm sản phẩm mới</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Danh mục *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{
                                    $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tồn kho *</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0"
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá bán (₫) *</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price') }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá gốc (₫)</label>
                            <input type="number" name="original_price" class="form-control"
                                value="{{ old('original_price') }}" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thông số kỹ thuật</label>
                        <textarea name="specifications" class="form-control" rows="3"
                            placeholder="Màn hình: 6.7&quot; | CPU: A17 | RAM: 8GB | ...">{{ old('specifications') }}</textarea>
                        <small class="form-text text-muted">Dùng dấu | để ngăn cách các thông số</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ảnh sản phẩm</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Lưu sản phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection