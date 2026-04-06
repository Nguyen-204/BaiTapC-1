@extends('layouts.admin')
@section('title', 'Sửa sản phẩm')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil"></i> Sửa sản phẩm: {{ $product->name }}</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Danh mục *</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->
                                    category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tồn kho *</label>
                            <input type="number" name="stock" class="form-control"
                                value="{{ old('stock', $product->stock) }}" min="0" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá bán (₫) *</label>
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price', $product->price) }}" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá gốc (₫)</label>
                            <input type="number" name="original_price" class="form-control"
                                value="{{ old('original_price', $product->original_price) }}" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description" class="form-control"
                            rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Thông số kỹ thuật</label>
                        <textarea name="specifications" class="form-control"
                            rows="3">{{ old('specifications', $product->specifications) }}</textarea>
                        <small class="form-text text-muted">Dùng dấu | để ngăn cách</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ảnh sản phẩm</label>
                        @if($product->image)
                        <div class="mb-2"><img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                style="max-height:200px"></div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if($product->getRawOriginal('image'))
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="1" name="remove_image"
                                id="removeImage">
                            <label class="form-check-label" for="removeImage">
                                Xóa ảnh hiện tại
                            </label>
                        </div>
                        @endif
                        <small class="form-text text-muted">Để trống nếu không thay đổi ảnh. Chọn ảnh mới sẽ thay ảnh cũ.</small>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Cập nhật</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection
