<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
		$table->boolean('unlimited_words')->default(false);
		$table->boolean('concept_map')->default(false);
		$table->boolean('custom_plan')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
		$table->dropColumn('unlimited_words');
		$table->dropColumn('concept_map');
		$table->dropColumn('custom_plan');
        });
    }
};
