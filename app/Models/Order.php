<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // da riscrivere tutto secondo ORDER
    // aggiornamento: riscritto e rivedere possibili errori
      use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'id_user' => 'integer',
        'price' => 'double',
    ];


    public function user(): Model
    {
        return $this->belongsTo(User::class, 'id_user', 'ID')->first();
    }
}
