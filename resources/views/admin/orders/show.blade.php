@extends('layouts.admin')
@section('title', 'Đơn hàng #' . $order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Đơn hàng #{{ $order->id }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Quay
        lại</a>
</div>

<div class="row">
    <div class="col-md-8">
        {{-- Order Items --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Sản phẩm đặt mua</div>
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
                            <td colspan="3" class="text-end fw-bold fs-5">Tổng:</td>
                            <td class="fw-bold fs-5 text-danger">{{ number_format($order->total) }} ₫</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        {{-- Customer Info --}}
        <div class="card mb-4">
            <div class="card-header fw-bold">Thông tin khách hàng</div>
            <div class="card-body">
                <p><strong>Tên TK:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                <hr>
                <p><strong>Người nhận:</strong> {{ $order->name }}</p>
                <p><strong>SĐT:</strong> {{ $order->phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                @if($order->note)<p><strong>Ghi chú:</strong> {{ $order->note }}</p>@endif
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Update Status --}}
        <div class="card">
            <div class="card-header fw-bold">Cập nhật trạng thái</div>
            <div class="card-body">
                <p>Trạng thái hiện tại: <span class="badge status-{{ $order->status }} fs-6">{{ $order->status_label
                        }}</span></p>
                @php
                    $statusOptions = \App\Models\Order::statusOptions();
                    $availableStatuses = array_unique(array_merge([$order->status], $order->allowedTransitions()));
                @endphp
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select mb-3">
                        @foreach($availableStatuses as $status)
                        <option value="{{ $status }}" {{ $order->status==$status?'selected':'' }}>{{
                            $statusOptions[$status] ?? $status }}</option>
                        @endforeach
                    </select>
                    @if(empty($order->allowedTransitions()))
                    <p class="small text-muted">Đơn này đã ở trạng thái cuối, không còn bước chuyển tiếp hợp lệ.</p>
                    @endif
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-lg"></i> Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
