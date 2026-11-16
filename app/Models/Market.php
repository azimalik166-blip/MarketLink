<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model; class Market extends Model { protected $fillable=['name','address','days','hours','latitude','longitude','map_provider','is_active']; public function products(){return $this->hasMany(Product::class);} }
