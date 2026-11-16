<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('activity_logs')) Schema::create('activity_logs', function(Blueprint $t){
            $t->id(); $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); $t->string('action',80); $t->string('description',500); $t->string('entity_type')->nullable(); $t->unsignedBigInteger('entity_id')->nullable(); $t->ipAddress('ip_address')->nullable(); $t->timestamps(); $t->index(['entity_type','entity_id']); $t->index(['user_id','created_at']);
        });
    }
    public function down(): void {Schema::dropIfExists('activity_logs');}
};
