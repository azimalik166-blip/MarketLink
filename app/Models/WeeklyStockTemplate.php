<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WeeklyStockTemplate extends Model {
    protected $fillable=['farmer_id','category_id','market_id','name','description','price','unit','target_quantity','is_active'];
    protected $casts=['price'=>'decimal:2','target_quantity'=>'integer','is_active'=>'boolean'];
    public function farmer(){return $this->belongsTo(User::class,'farmer_id');}
    public function category(){return $this->belongsTo(Category::class);}
    public function market(){return $this->belongsTo(Market::class);}
}
