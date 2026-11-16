<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FarmerProfile extends Model {
    protected $fillable=['user_id','stall_name','bio','operating_days','pickup_windows','order_cutoff_time','address','latitude','longitude','approval_status'];
    protected $casts=['order_cutoff_time'=>'datetime:H:i'];
    public function user(){return $this->belongsTo(User::class);}
}
