<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'customer_id',
        'farmer_id',
        'product_id',
        'rating',
        'comment',
        'farmer_reply',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
