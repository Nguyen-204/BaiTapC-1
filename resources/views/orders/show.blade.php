@extends('layouts.app')
@section('title', 'Đơn hàng #' . $order->id)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Đơn hàng</a></li>
            <li class="breadcrumb-item active">#{{ $order->id }}</li>
        </ol>
    </nav>

    <h2 class="mb-4">Đơn hàng #{{ $order->id }} <span class="badge status-{{ $order->status }}">{{ $order->status_label
            }}</span></h2>

    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header fw-bold">Sản phẩm đã đặt</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>SL</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->price) }} ₫</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">{{ number_format($item->subtotal) }} ₫</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold fs-5">Tổng cộng:</td>
                                <td class="fw-bold fs-5 text-danger">{{ number_format($order->total) }} ₫</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header fw-bold">Thông tin giao hàng</div>
                <div class="card-body">
                    <p><strong>Người nhận:</strong> {{ $order->name }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    @if($order->note)<p><strong>Ghi chú:</strong> {{ $order->note }}</p>@endif
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Thanh toán:</strong> COD (Nhận hàng trả tiền)</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection