@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4"><i class="bi bi-bar-chart-line"></i> Dashboard</h2>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color:#0d6efd">
            <div class="card-body">
                <h6 class="text-muted">Sản phẩm</h6>
                <h2 class="fw-bold text-primary">{{ $stats['products'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color:#198754">
            <div class="card-body">
                <h6 class="text-muted">Đơn hàng</h6>
                <h2 class="fw-bold text-success">{{ $stats['orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color:#6f42c1">
            <div class="card-body">
                <h6 class="text-muted">Khách hàng</h6>
                <h2 class="fw-bold" style="color:#6f42c1">{{ $stats['customers'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color:#dc3545">
            <div class="card-body">
                <h6 class="text-muted">Doanh thu</h6>
                <h4 class="fw-bold text-danger">{{ number_format($stats['revenue']) }} ₫</h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Đơn hàng mới nhất</strong>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->id }}</a></td>
                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                    <td class="fw-bold">{{ number_format($order->total) }} ₫</td>
                    <td><span class="badge status-{{ $order->status }}">{{ $order->status_label }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">Chưa có đơn hàng nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
