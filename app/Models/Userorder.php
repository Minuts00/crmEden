<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Userorder extends Model
{
      use HasFactory;

    //   da rivedere e risettare eventualmente

    protected $table = 'userorders';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_user',
    ];

    protected $casts = [
        'id_order' => 'integer',
        'id_user' => 'integer',
    ];

    public function user(): Model
    {
        return $this->belongsTo(User::class, 'id_user', 'ID')->first();
    }

    public function userOrder(): Model
    {
        return $this->belongsTo(Order::class, 'id_order', 'ID')->first();
    }

}
