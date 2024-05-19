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
		$table->text('wordsUsed')->nullable();
		$table->text('conceptualMap')->nullable();
		$table->text('summary')->nullable();
		$table->text('questionsUsed')->nullable();
		$table->text('voiceOver')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('history', function (Blueprint $table) {
		$table->dropColumn('wordsUsed');
		$table->dropColumn('conceptualMap');
		$table->dropColumn('summary');
		$table->dropColumn('questionsUsed');
		$table->dropColumn('voiceOver');
        });
    }
};
