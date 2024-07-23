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
        Schema::table('creditos', function (Blueprint $table) {
		$table->dropColumn('idTipo');
		$table->dropColumn('cantidad');

		$table->integer('palabras')->default(0);
		$table->integer('preguntas')->default(0);
		$table->integer('resumenes')->default(0);
		$table->integer('mapa')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit', function (Blueprint $table) {
		$table->unsignedBigInteger('idTipo');
		$table->integer('cantidad');

		$table->dropColumn('palabras');
		$table->dropColumn('preguntas');
		$table->dropColumn('resumenes');
		$table->dropColumn('mapa');
        });
    }
};
