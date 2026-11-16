<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('saved_markets')) Schema::create('saved_markets', function(Blueprint $t){
            $t->id(); $t->foreignId('customer_id')->constrained('users')->cascadeOnDelete(); $t->foreignId('market_id')->constrained()->cascadeOnDelete(); $t->timestamps(); $t->unique(['customer_id','market_id']);
        });
    }
    public function down(): void {Schema::dropIfExists('saved_markets');}
};
