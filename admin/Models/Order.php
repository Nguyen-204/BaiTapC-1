<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_SHIPPING = 'shipping';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_METHOD_COD = 'cod';
    public const PAYMENT_METHOD_QR = 'qr';

    public const PAYMENT_STATUS_UNPAID = 'unpaid';
    public const PAYMENT_STATUS_WAITING_TRANSFER = 'waiting_transfer';
    public const PAYMENT_STATUS_PENDING_CONFIRMATION = 'pending_confirmation';
    public const PAYMENT_STATUS_PAID = 'paid';
    public const PAYMENT_STATUS_EXPIRED = 'expired';

    private const STATUS_LABELS = [
        self::STATUS_PENDING => 'Chờ xác nhận',
        self::STATUS_CONFIRMED => 'Đã xác nhận',
        self::STATUS_SHIPPING => 'Đang giao',
        self::STATUS_COMPLETED => 'Hoàn thành',
        self::STATUS_CANCELLED => 'Đã hủy',
    ];

    private const STATUS_COLORS = [
        self::STATUS_PENDING => 'warning',
        self::STATUS_CONFIRMED => 'info',
        self::STATUS_SHIPPING => 'primary',
        self::STATUS_COMPLETED => 'success',
        self::STATUS_CANCELLED => 'danger',
    ];

    private const STATUS_TRANSITIONS = [
        self::STATUS_PENDING => [self::STATUS_CONFIRMED, self::STATUS_CANCELLED],
        self::STATUS_CONFIRMED => [self::STATUS_SHIPPING, self::STATUS_CANCELLED],
        self::STATUS_SHIPPING => [self::STATUS_COMPLETED, self::STATUS_CANCELLED],
        self::STATUS_COMPLETED => [],
        self::STATUS_CANCELLED => [self::STATUS_CONFIRMED],
    ];

    private const PAYMENT_METHOD_LABELS = [
        self::PAYMENT_METHOD_COD => 'COD',
        self::PAYMENT_METHOD_QR => 'Chuyển khoản QR',
    ];

    private const PAYMENT_STATUS_LABELS = [
        self::PAYMENT_STATUS_UNPAID => 'Chưa thanh toán',
        self::PAYMENT_STATUS_WAITING_TRANSFER => 'Chờ chuyển khoản',
        self::PAYMENT_STATUS_PENDING_CONFIRMATION => 'Chờ admin xác nhận',
        self::PAYMENT_STATUS_PAID => 'Đã thanh toán',
        self::PAYMENT_STATUS_EXPIRED => 'QR hết hạn',
    ];

    private const PAYMENT_STATUS_COLORS = [
        self::PAYMENT_STATUS_UNPAID => 'secondary',
        self::PAYMENT_STATUS_WAITING_TRANSFER => 'warning',
        self::PAYMENT_STATUS_PENDING_CONFIRMATION => 'info',
        self::PAYMENT_STATUS_PAID => 'success',
        self::PAYMENT_STATUS_EXPIRED => 'danger',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'note',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'qr_expires_at',
        'payment_requested_at',
        'payment_confirmed_at',
    ];

    protected $casts = [
        'qr_expires_at' => 'datetime',
        'payment_requested_at' => 'datetime',
        'payment_confirmed_at' => 'datetime',
    ];

    public static function statusOptions(): array
    {
        return self::STATUS_LABELS;
    }

    public static function paymentStatusOptions(): array
    {
        return self::PAYMENT_STATUS_LABELS;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function allowedTransitions(): array
    {
        return self::STATUS_TRANSITIONS[$this->status] ?? [];
    }

    public function canTransitionTo(string $status): bool
    {
        return $this->status === $status || in_array($status, $this->allowedTransitions(), true);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'secondary';
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHOD_LABELS[$this->payment_method] ?? strtoupper((string) $this->payment_method);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUS_LABELS[$this->payment_status] ?? (string) $this->payment_status;
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return self::PAYMENT_STATUS_COLORS[$this->payment_status] ?? 'secondary';
    }

    public function isQrPayment(): bool
    {
        return $this->payment_method === self::PAYMENT_METHOD_QR;
    }

    public function isQrExpired(): bool
    {
        return $this->isQrPayment()
            && $this->qr_expires_at instanceof Carbon
            && $this->qr_expires_at->isPast();
    }

    public function canSubmitQrPayment(): bool
    {
        return $this->isQrPayment()
            && $this->payment_status === self::PAYMENT_STATUS_WAITING_TRANSFER
            && !$this->isQrExpired();
    }

    public function canConfirmQrPayment(): bool
    {
        return $this->isQrPayment() && $this->payment_status === self::PAYMENT_STATUS_PENDING_CONFIRMATION;
    }

    public function syncPaymentState(): self
    {
        if (
            $this->payment_method === self::PAYMENT_METHOD_QR
            && $this->payment_status === self::PAYMENT_STATUS_WAITING_TRANSFER
            && $this->isQrExpired()
        ) {
            $this->forceFill([
                'payment_status' => self::PAYMENT_STATUS_EXPIRED,
            ])->save();
        }

        return $this;
    }
}
