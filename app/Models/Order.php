<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    
      use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        // 'id_user',
        'name',
        'description',
        'price',
        'payment_proof',
    ];
     protected $guarded = []; // oppure niente

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id'); 
    }
}
