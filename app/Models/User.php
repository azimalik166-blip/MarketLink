<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable=['name','email','phone','address','role','status','password'];
    protected $hidden=['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; }
    public function farmerProfile():HasOne{return $this->hasOne(FarmerProfile::class);}
    public function products():HasMany{return $this->hasMany(Product::class,'farmer_id');}
    public function customerOrders():HasMany{return $this->hasMany(Order::class,'customer_id');}
    public function farmerOrders():HasMany{return $this->hasMany(Order::class,'farmer_id');}
    public function notifications():HasMany{return $this->hasMany(UserNotification::class,'user_id');}
    public function favorites():HasMany{return $this->hasMany(Favorite::class,'user_id');}
    public function cartItems():HasMany{return $this->hasMany(CartItem::class,'user_id');}
    public function pickupSlots():HasMany{return $this->hasMany(PickupSlot::class,'farmer_id');}
    public function savedMarkets():HasMany{return $this->hasMany(SavedMarket::class,'customer_id');}
    public function weeklyStockTemplates():HasMany{return $this->hasMany(WeeklyStockTemplate::class,'farmer_id');}
    public function activityLogs():HasMany{return $this->hasMany(ActivityLog::class);}
}
