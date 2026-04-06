@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')

@section('content')
<h2 class="mb-4"><i class="bi bi-bag"></i> Quản lý đơn hàng</h2>

{{-- Status filter --}}
<div class="mb-3">
    <a href="{{ route('admin.orders.index') }}"
        class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">Tất cả</a>
    <a href="{{ route('admin.orders.index', ['status'=>'pending']) }}"
        class="btn btn-sm {{ request('status')=='pending' ? 'btn-warning' : 'btn-outline-warning' }}">⏳ Chờ xác nhận</a>
    <a href="{{ route('admin.orders.index', ['status'=>'confirmed']) }}"
        class="btn btn-sm {{ request('status')=='confirmed' ? 'btn-info' : 'btn-outline-info' }}">✅ Đã xác nhận</a>
    <a href="{{ route('admin.orders.index', ['status'=>'shipping']) }}"
        class="btn btn-sm {{ request('status')=='shipping' ? 'btn-primary' : 'btn-outline-primary' }}">🚚 Đang giao</a>
    <a href="{{ route('admin.orders.index', ['status'=>'completed']) }}"
        class="btn btn-sm {{ request('status')=='completed' ? 'btn-success' : 'btn-outline-success' }}">🎉 Hoàn
        thành</a>
    <a href="{{ route('admin.orders.index', ['status'=>'cancelled']) }}"
        class="btn btn-sm {{ request('status')=='cancelled' ? 'btn-danger' : 'btn-outline-danger' }}">❌ Đã hủy</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->user->name ?? $order->name }}</td>
                    <td>{{ $order->phone ?? 'N/A' }}</td>
                    <td class="fw-bold text-danger">{{ number_format($order->total) }} ₫</td>
                    <td><span class="badge status-{{ $order->status }}">{{ $order->status_label }}</span></td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order->id) }}"
                            class="btn btn-outline-primary btn-sm">Chi tiết</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">Không có đơn hàng nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">{{ $orders->links('pagination::bootstrap-5') }}</div>
@endsection
