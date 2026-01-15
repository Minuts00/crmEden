<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    // da riscrivere tutto secondo PRODUCT
    // aggiornamento: rivedere e settare tocchi finali
    // integrare stock di tipo BOOLEANO IN DB(SCRIVERE SU MIGRAZIONE)
      use HasFactory;
   

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'category',
        'name',
        'description',
        'price_list',
        'price_min',
        'img',
        'stock',  
    ];

    protected $casts = [
        'id_user' => 'integer',
        'id_category' => 'integer',
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
                    -where('is_active', true)
                    ->ordered();
    }

    public function getAllImagesAttribute()
    {
        return $this->images()->active()->ordered()->get();
    }

    public function getMainImageUrlAttribute()
    {
        if ($this->primaryImages) {
            return $this->primaryImage->image_url;
        }
        if(!empty($this->img)) {
            if(filter_var($this->img, FILTER_VALIDATE_URL)) {
                return $this->img;
            }
            return asset ('storage/' . $this->img);
        }
    }

    public function category(): Model
    {
        return $this->belongsTo(Category::class, 'id_category', 'ID')->first();
    }

     public function user(): Model
    {
        return $this->belongsTo(User::class, 'id_user', 'ID')->first();
    }

}
