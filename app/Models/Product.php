<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // da riscrivere tutto secondo PRODUCT
    // aggiornamento: rivedere e settare tocchi finali
    // integrare stock di tipo BOOLEANO IN DB(SCRIVERE SU MIGRAZIONE)
      use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'id_category',
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

    public function category(): Model
    {
        return $this->belongsTo(Category::class, 'id_category', 'ID')->first();
    }

     public function user(): Model
    {
        return $this->belongsTo(User::class, 'id_user', 'ID')->first();
    }

}
