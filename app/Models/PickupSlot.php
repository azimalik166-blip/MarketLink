<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupSlot extends Model
{
    protected $fillable = [
        'farmer_id', 'market_id', 'slot_date', 'start_time', 'end_time', 'capacity', 'is_active'
    ];

    protected $casts = [
        'slot_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function label(): string
    {
        return date('h:i A', strtotime($this->start_time)) . ' - ' . date('h:i A', strtotime($this->end_time));
    }
}
