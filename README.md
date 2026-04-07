# PhoneShop

Website ban dien thoai xay dung bang Laravel 10, SQLite, Bootstrap 5.

## Chay local tren Windows

Chay:

```powershell
.\start.cmd
```

Hoac:

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\start.ps1
```

Truy cap: `http://localhost:8000`

Dung server:

```powershell
.\stop.cmd
```

Hoac:

```powershell
powershell -NoProfile -ExecutionPolicy Bypass -File .\stop.ps1
```

Bien moi truong ho tro:
- `$env:PHONESHOP_PORT='9000'; .\start.cmd`
- `$env:PHONESHOP_URL_HOST='192.168.1.191'; .\start.cmd`
- `$env:PHONESHOP_DB_CONNECTION='mysql'; $env:PHONESHOP_DB_HOST='127.0.0.1'; $env:PHONESHOP_DB_PORT='3306'; $env:PHONESHOP_DB_DATABASE='phone_shop'; $env:PHONESHOP_DB_USERNAME='root'; $env:PHONESHOP_DB_PASSWORD=''; .\start.cmd`

Script se tu bootstrap runtime Laravel vao `.phoneshop-runtime/`, tu tai local PHP/Composer neu can, migrate + seed, roi start server local.

Tai lieu code flow va bootstrap:
- [CODE_FLOW.md](CODE_FLOW.md)

## Tai khoan demo

| Vai tro | Email | Mat khau |
|---------|-------|----------|
| Admin | admin@phoneshop.com | password |
| Khach hang | nguyenvana@gmail.com | password |

## Chuc nang

Nguoi dung:
- Xem danh sach, chi tiet san pham
- Tim kiem, loc theo hang/gia
- Gio hang
- Dat hang COD
- Dang ky / Dang nhap
- Xem lich su don hang

Admin:
- Dashboard thong ke
- CRUD san pham, danh muc
- Quan ly don hang

## Cong nghe

- PHP 8.2 + Laravel 10
- SQLite
- Blade Template + Bootstrap 5
