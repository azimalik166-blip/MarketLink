<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (Schema::hasTable('farmer_profiles') && !Schema::hasColumn('farmer_profiles','order_cutoff_time')) {
            Schema::table('farmer_profiles', function(Blueprint $t){$t->time('order_cutoff_time')->nullable()->after('pickup_windows');});
        }
    }
    public function down(): void {
        if (Schema::hasTable('farmer_profiles') && Schema::hasColumn('farmer_profiles','order_cutoff_time')) {
            Schema::table('farmer_profiles', function(Blueprint $t){$t->dropColumn('order_cutoff_time');});
        }
    }
};
