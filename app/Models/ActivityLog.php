<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ActivityLog extends Model {
    public $timestamps=true;
    protected $fillable=['user_id','action','description','entity_type','entity_id','ip_address'];
    public function user(){return $this->belongsTo(User::class);}
}
