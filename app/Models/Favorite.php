<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable=['user_id','farmer_id','product_id'];
    public function product(){return $this->belongsTo(Product::class);}
    public function farmer(){return $this->belongsTo(User::class,'farmer_id');}
    public function user(){return $this->belongsTo(User::class,'user_id');}
}
