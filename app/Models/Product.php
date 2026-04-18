<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
      use HasFactory;
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price_list',
        'price_min',
        'img',
        'stock',  
    ];

    protected $casts = [
        'category_id' => 'integer',
        'price_list' => 'double',
        'price_min' => 'double',
        'stock' => 'boolean',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    public function primaryImage(): HasOne
    {
        return $this -> hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(ProductImage::class)
                    ->where('type', 'gallery')
                    ->where('is_active', true)
                    ->ordered();
    }

    public function getAllImagesAttribute()
    {
        return $this->images()->active()->ordered()->get();
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->primaryImages) {
            return $this->primaryImage->img_path;
        }
        if (!empty($this->img)) {
            if (filter_var($this->img, FILTER_VALIDATE_URL)) {
                return $this->img;
            }
            return asset('storage/' . $this->img);
        }
        return null;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'ID');
    }

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
