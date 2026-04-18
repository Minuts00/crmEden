<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'productimages';

    protected $fillable = [
        'product_id',
        'img_path',
        'type',
        'order',
        'alt_text',
        'caption',
        'is_primary',
        'is_active',
    ];


    protected $casts = [
        'order' => 'integer',
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeOrdered($query)
    {
     return $query->orderBy('order')->orderBy('created_at');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getImagePathAttribute(): string
    {
        return storage_path('app/public/' . ltrim($this->img_path, '/'));
    }
}
