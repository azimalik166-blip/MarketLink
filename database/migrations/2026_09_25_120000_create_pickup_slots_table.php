<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pickup_slots', function (Blueprint $t) {
            $t->id();
            $t->foreignId('farmer_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('market_id')->nullable()->constrained()->nullOnDelete();
            $t->date('slot_date');
            $t->time('start_time');
            $t->time('end_time');
            $t->unsignedInteger('capacity')->default(5);
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->unique(['farmer_id', 'slot_date', 'start_time', 'end_time']);
            $t->index(['farmer_id', 'slot_date', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pickup_slots');
    }
};
