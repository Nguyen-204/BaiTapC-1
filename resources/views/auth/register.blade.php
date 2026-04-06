@extends('layouts.app')
@section('title', 'Đăng ký')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus display-4 text-primary"></i>
                        <h3 class="mt-2">Đăng ký tài khoản</h3>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Họ tên</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required placeholder="Nguyễn Văn A">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required placeholder="email@example.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mật khẩu</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required
                                placeholder="Tối thiểu 6 ký tự">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Xác nhận mật khẩu</label>
                            <input type="password" name="password_confirmation" class="form-control" required
                                placeholder="Nhập lại mật khẩu">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-lg">Đăng ký</button>
                    </form>
                    <hr>
                    <p class="text-center mb-0">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection