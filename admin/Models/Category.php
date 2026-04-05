<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    private const DEFAULT_IMAGE_MAP = [
        'apple' => 'products/iphone-15-pro-max-256gb.png',
        'samsung' => 'products/samsung-galaxy-s24-ultra.png',
        'xiaomi' => 'products/xiaomi-14-ultra.png',
        'oppo' => 'products/oppo-a79-5g.png',
        'vivo' => 'products/vivo-y36.png',
        'realme' => 'products/realme-gt-5-pro.png',
    ];

    protected $fillable = ['name', 'slug'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImagePathAttribute(): ?string
    {
        return self::DEFAULT_IMAGE_MAP[$this->attributes['slug'] ?? ''] ?? null;
    }
}
