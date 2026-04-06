<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    private const DEFAULT_IMAGE_MAP = [
        'iphone-15-pro-max-256gb' => 'products/iphone-15-pro-max-256gb.png',
        'iphone-15-128gb' => 'products/iphone-15-128gb.png',
        'iphone-14-128gb' => 'products/iphone-14-128gb.jpg',
        'samsung-galaxy-s24-ultra' => 'products/samsung-galaxy-s24-ultra.png',
        'samsung-galaxy-a55-5g' => 'products/samsung-galaxy-a55-5g.png',
        'samsung-galaxy-a15' => 'products/samsung-galaxy-a15.png',
        'xiaomi-14-ultra' => 'products/xiaomi-14-ultra.png',
        'redmi-note-13-pro-5g' => 'products/redmi-note-13-pro-5g.png',
        'oppo-find-x7-ultra' => 'products/oppo-find-x7-ultra.jpg',
        'oppo-a79-5g' => 'products/oppo-a79-5g.png',
        'vivo-x100-pro' => 'products/vivo-x100-pro.jpg',
        'vivo-y36' => 'products/vivo-y36.png',
        'realme-gt-5-pro' => 'products/realme-gt-5-pro.png',
        'realme-c67' => 'products/realme-c67.png',
    ];

    protected $fillable = [
        'category_id', 'name', 'slug', 'price', 'original_price',
        'description', 'specifications', 'image', 'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        return self::DEFAULT_IMAGE_MAP[$this->attributes['slug'] ?? ''] ?? null;
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price) . ' ₫';
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return $this->original_price ? number_format($this->original_price) . ' ₫' : null;
    }

    public function getDiscountPercentAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round(100 - ($this->price / $this->original_price * 100));
        }
        return 0;
    }
}
