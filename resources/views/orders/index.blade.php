@extends('layouts.app')
@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-bag"></i> Lịch sử đơn hàng</h2>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bag-x display-1 text-muted"></i>
        <h4 class="mt-3 text-muted">Bạn chưa có đơn hàng nào</h4>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Mua sắm ngay</a>
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-bold text-danger">{{ number_format($order->total) }} ₫</td>
                    <td><span class="badge status-{{ $order->status }}">{{ $order->status_label }}</span></td>
                    <td><a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">Chi
                            tiết</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">{{ $orders->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
