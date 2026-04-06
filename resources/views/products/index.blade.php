@extends('layouts.app')
@section('title', 'Sản phẩm')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">
        @if(request('search'))
        Kết quả tìm kiếm: "{{ request('search') }}"
        @else
        Tất cả sản phẩm
        @endif
    </h2>

    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="bi bi-funnel"></i> Bộ lọc</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <h6 class="fw-bold">Danh mục</h6>
                        @foreach($categories as $cat)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="{{ $cat->id }}"
                                id="cat{{ $cat->id }}" {{ request('category')==$cat->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $cat->id }}">
                                {{ $cat->name }} <small class="text-muted">({{ $cat->products_count }})</small>
                            </label>
                        </div>
                        @endforeach

                        <hr>
                        <h6 class="fw-bold">Khoảng giá</h6>
                        @php
                        $priceRanges = [
                        ['label'=>'Dưới 5 triệu','min'=>0,'max'=>5000000],
                        ['label'=>'5 - 10 triệu','min'=>5000000,'max'=>10000000],
                        ['label'=>'10 - 20 triệu','min'=>10000000,'max'=>20000000],
                        ['label'=>'Trên 20 triệu','min'=>20000000,'max'=>''],
                        ];
                        @endphp
                        @foreach($priceRanges as $i => $pr)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="price_range" value="{{ $i }}"
                                id="price{{ $i }}" {{ request('price_range')===(string)$i ? 'checked' : '' }}
                                onchange="this.form.querySelector('[name=price_min]').value='{{ $pr['min'] }}';this.form.querySelector('[name=price_max]').value='{{ $pr['max'] }}';">
                            <label class="form-check-label" for="price{{ $i }}">{{ $pr['label'] }}</label>
                        </div>
                        @endforeach
                        <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                        <input type="hidden" name="price_max" value="{{ request('price_max') }}">

                        <hr>
                        <h6 class="fw-bold">Sắp xếp</h6>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="">Mới nhất</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ?'selected':'' }}>Giá tăng dần
                            </option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ?'selected':'' }}>Giá giảm dần
                            </option>
                            <option value="name_asc" {{ request('sort')=='name_asc' ?'selected':'' }}>Tên A-Z</option>
                        </select>

                        <button class="btn btn-primary btn-sm w-100 mt-3" type="submit"><i class="bi bi-search"></i>
                            Lọc</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Xóa
                            bộ lọc</a>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-md-9">
            <p class="text-muted">Hiển thị {{ $products->count() }} / {{ $products->total() }} sản phẩm</p>

            @if($products->isEmpty())
            <div class="alert alert-info">Không tìm thấy sản phẩm nào phù hợp.</div>
            @else
            <div class="row g-3">
                @foreach($products as $product)
                <div class="col-6 col-lg-4">
                    <div class="card product-card h-100 position-relative">
                        @if($product->discount_percent > 0)
                        <span class="badge bg-danger discount-badge">-{{ $product->discount_percent }}%</span>
                        @endif
                        @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                        <div class="product-image-shell product-image-shell-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" class="product-image"
                                alt="{{ $product->name }}">
                        </div>
                        @else
                        <div class="product-img-placeholder"><i class="bi bi-phone"></i></div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title mb-1">{{ $product->name }}</h6>
                            <span class="badge bg-secondary mb-2" style="width:fit-content">{{ $product->category->name
                                ?? '' }}</span>
                            <div class="mt-auto">
                                <span class="price-current">{{ $product->formatted_price }}</span>
                                @if($product->formatted_original_price)
                                <span class="price-original ms-1">{{ $product->formatted_original_price }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="{{ route('products.show', $product->id) }}"
                                class="btn btn-primary btn-sm w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
