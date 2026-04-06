@extends('layouts.admin')
@section('title', 'Sửa danh mục')

@section('content')
<h2 class="mb-4"><i class="bi bi-pencil"></i> Sửa danh mục: {{ $category->name }}</h2>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Tên danh mục *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> Cập nhật</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
@endsection