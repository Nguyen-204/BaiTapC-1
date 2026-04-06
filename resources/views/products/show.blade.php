@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container py-4">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category'=>$product->category_id]) }}">{{
                    $product->category->name ?? '' }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row mb-5">
        {{-- Product Image --}}
        <div class="col-md-5 mb-3">
            @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
            <div class="product-image-shell product-image-shell-lg rounded shadow">
                <img src="{{ asset('storage/' . $product->image) }}" class="product-image" alt="{{ $product->name }}">
            </div>
            @else
            <div class="product-img-placeholder product-img-placeholder-lg rounded shadow"><i class="bi bi-phone"></i>
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="col-md-7">
            <h1 class="h2 fw-bold">{{ $product->name }}</h1>
            <p><span class="badge bg-secondary fs-6">{{ $product->category->name ?? '' }}</span></p>

            <div class="mb-3">
                <span class="price-current fs-3">{{ $product->formatted_price }}</span>
                @if($product->formatted_original_price)
                <span class="price-original fs-5 ms-2">{{ $product->formatted_original_price }}</span>
                <span class="badge bg-danger ms-2">-{{ $product->discount_percent }}%</span>
                @endif
            </div>

            <p class="text-muted">
                <i class="bi bi-box-seam"></i> Còn <strong>{{ $product->stock }}</strong> sản phẩm
            </p>

            @if($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-3 mb-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <label class="fw-semibold">Số lượng:</label>
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                    class="form-control cart-qty">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                </button>
            </form>
            @else
            <div class="alert alert-warning"><i class="bi bi-exclamation-triangle"></i> Sản phẩm tạm hết hàng</div>
            @endif

            <hr>
            <h5>Mô tả sản phẩm</h5>
            <p>{{ $product->description ?? 'Chưa có mô tả.' }}</p>
        </div>
    </div>

    {{-- Specifications --}}
    @if($product->specifications)
    <div class="mb-5">
        <h4 class="mb-3"><i class="bi bi-cpu"></i> Thông số kỹ thuật</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    @foreach(explode('|', $product->specifications) as $spec)
                    @php $parts = explode(':', $spec, 2); @endphp
                    @if(count($parts) == 2)
                    <tr>
                        <th class="bg-light" style="width:200px">{{ trim($parts[0]) }}</th>
                        <td>{{ trim($parts[1]) }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Related Products --}}
    @if($relatedProducts->count() > 0)
    <div class="mb-5">
        <h4 class="mb-3"><i class="bi bi-grid"></i> Sản phẩm liên quan</h4>
        <div class="row g-3">
            @foreach($relatedProducts as $rp)
            <div class="col-6 col-md-3">
                <div class="card product-card h-100">
                    @if($rp->image && file_exists(storage_path('app/public/' . $rp->image)))
                    <div class="product-image-shell product-image-shell-sm" style="height:150px">
                        <img src="{{ asset('storage/' . $rp->image) }}" class="product-image" alt="{{ $rp->name }}">
                    </div>
                    @else
                    <div class="product-img-placeholder" style="min-height:150px;font-size:2rem"><i
                            class="bi bi-phone"></i></div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $rp->name }}</h6>
                        <span class="price-current">{{ $rp->formatted_price }}</span>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <a href="{{ route('products.show', $rp->id) }}" class="btn btn-outline-primary btn-sm w-100">Xem
                            chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
