<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method',
        'price',
        'postal_code',
        'address',
        'building',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
}