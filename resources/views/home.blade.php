@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')
{{-- HERO BANNER --}}
<section class="hero-banner text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3"><i class="bi bi-phone"></i> PhoneShop</h1>
        <p class="lead mb-4">Điện thoại chính hãng &mdash; Giá tốt nhất &mdash; Giao hàng toàn quốc</p>
        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg px-5">
            <i class="bi bi-grid"></i> Xem tất cả sản phẩm
        </a>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="container my-5">
    <h2 class="mb-4 text-center">Danh mục hãng điện thoại</h2>
    <div class="row g-3 justify-content-center">
        @foreach($categories as $cat)
        <div class="col-6 col-md-2">
            @php $categoryImage = $cat->image_path; @endphp
            <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                class="card category-card text-center p-3 text-decoration-none">
                <div class="category-card-media">
                    @if($categoryImage && file_exists(storage_path('app/public/' . $categoryImage)))
                    <img src="{{ asset('storage/' . $categoryImage) }}" alt="{{ $cat->name }}">
                    @else
                    <div class="category-card-icon" aria-hidden="true"><i class="bi bi-phone"></i></div>
                    @endif
                </div>
                <div class="fw-semibold text-dark">{{ $cat->name }}</div>
                <small class="text-muted">{{ $cat->products_count }} sản phẩm</small>
            </a>
        </div>
        @endforeach
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="container mb-5">
    <h2 class="mb-4 text-center">Sản phẩm mới nhất</h2>
    <div class="row g-4">
        @foreach($featuredProducts as $product)
        <div class="col-6 col-md-3">
            <div class="card product-card h-100 position-relative">
                @if($product->discount_percent > 0)
                <span class="badge bg-danger discount-badge">-{{ $product->discount_percent }}%</span>
                @endif

                @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                <div class="product-image-shell">
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-image"
                        alt="{{ $product->name }}">
                </div>
                @else
                <div class="product-img-placeholder"><i class="bi bi-phone"></i></div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="mb-0"><span class="badge bg-secondary">{{ $product->category->name ?? '' }}</span></p>
                    <div class="mt-auto pt-2">
                        <span class="price-current">{{ $product->formatted_price }}</span>
                        @if($product->formatted_original_price)
                        <br><span class="price-original">{{ $product->formatted_original_price }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pb-3">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm w-100">Xem chi
                        tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">Xem tất cả sản phẩm <i
                class="bi bi-arrow-right"></i></a>
    </div>
</section>
@endsection
