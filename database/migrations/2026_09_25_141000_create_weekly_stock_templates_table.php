<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('weekly_stock_templates')) Schema::create('weekly_stock_templates', function(Blueprint $t){
            $t->id();
            $t->foreignId('farmer_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('category_id')->constrained()->cascadeOnDelete();
            $t->foreignId('market_id')->nullable()->constrained()->nullOnDelete();
            $t->string('name'); $t->text('description')->nullable(); $t->decimal('price',10,2); $t->string('unit',50); $t->unsignedInteger('target_quantity')->default(0); $t->boolean('is_active')->default(true); $t->timestamps();
            $t->index(['farmer_id','is_active']);
        });
    }
    public function down(): void {Schema::dropIfExists('weekly_stock_templates');}
};
