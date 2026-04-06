@extends('layouts.app')
@section('title', 'Giỏ hàng')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h2>

    @if(empty($cart))
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">Giỏ hàng trống</h4>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
        </a>
    </div>
    @else
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th style="width:130px">Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @if(!empty($item['image']) && file_exists(storage_path('app/public/' . $item['image'])))
                            <div class="cart-item-media rounded">
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                    class="product-image">
                            </div>
                            @else
                            <div class="product-img-placeholder rounded"
                                style="width:60px;height:60px;min-height:auto;font-size:1.2rem"><i
                                    class="bi bi-phone"></i></div>
                            @endif
                            <div>
                                <strong>{{ $item['name'] }}</strong>
                                @if(!empty($item['stock']))
                                <div class="small text-muted">Còn {{ $item['stock'] }} sản phẩm</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ number_format($item['price']) }} ₫</td>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex gap-1">
                            @csrf @method('PATCH')
                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="99"
                                class="form-control form-control-sm cart-qty">
                            <button class="btn btn-outline-secondary btn-sm" title="Cập nhật"><i
                                    class="bi bi-arrow-repeat"></i></button>
                        </form>
                    </td>
                    <td class="fw-bold">{{ number_format($item['price'] * $item['quantity']) }} ₫</td>
                    <td>
                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" title="Xóa"><i
                                    class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="3" class="text-end fw-bold fs-5">Tổng cộng:</td>
                    <td colspan="2" class="fw-bold fs-5 text-danger">{{ number_format($total) }} ₫</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
        </a>
        <a href="{{ auth()->check() ? route('checkout') : route('login') }}" class="btn btn-success btn-lg">
            <i class="bi bi-credit-card"></i> {{ auth()->check() ? 'Thanh toán' : 'Đăng nhập để thanh toán' }}
        </a>
    </div>
    @endif
</div>
@endsection
