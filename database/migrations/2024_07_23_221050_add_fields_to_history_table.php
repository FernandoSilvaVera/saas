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
        Schema::table('history', function (Blueprint $table) {
								$table->boolean('conceptualMapSelected')->default(false);
								$table->boolean('summarySelected')->default(false);
								$table->boolean('questionsSelected')->default(false);
								$table->boolean('voiceOverSelected')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('history', function (Blueprint $table) {
								$table->dropColumn('conceptualMapSelected');
								$table->dropColumn('summarySelected');
								$table->dropColumn('questionsSelected');
								$table->dropColumn('voiceOverSelected');
        });
    }
};
