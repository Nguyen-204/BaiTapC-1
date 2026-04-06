@extends('layouts.app')
@section('title', 'Thanh toán')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-credit-card"></i> Thanh toán đơn hàng</h2>

    <form method="POST" action="{{ route('order.place') }}">
        @csrf
        <div class="row">
            {{-- Shipping Info --}}
            <div class="col-md-7 mb-4">
                <div class="card">
                    <div class="card-header fw-bold">Thông tin giao hàng</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ tên người nhận *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số điện thoại *</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" required placeholder="0912345678">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Địa chỉ giao hàng *</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                rows="3" required
                                placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành">{{ old('address') }}</textarea>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ghi chú</label>
                            <textarea name="note" class="form-control" rows="2"
                                placeholder="Ghi chú cho đơn hàng (tùy chọn)">{{ old('note') }}</textarea>
                        </div>
                        <div class="p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">Phương thức thanh toán</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" checked disabled>
                                <label class="form-check-label fw-semibold">
                                    💵 Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header fw-bold">Tóm tắt đơn hàng</div>
                    <div class="card-body">
                        @foreach($cart as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $item['name'] }} <small class="text-muted">x{{ $item['quantity'] }}</small></span>
                            <span class="fw-semibold">{{ number_format($item['price'] * $item['quantity']) }} ₫</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold fs-5">Tổng cộng:</span>
                            <span class="fw-bold fs-5 text-danger">{{ number_format($total) }} ₫</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-bag-check"></i> Đặt hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection