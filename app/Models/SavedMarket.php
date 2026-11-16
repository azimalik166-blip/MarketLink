<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SavedMarket extends Model {
    protected $fillable=['customer_id','market_id'];
    public function customer(){return $this->belongsTo(User::class,'customer_id');}
    public function market(){return $this->belongsTo(Market::class);}
}
