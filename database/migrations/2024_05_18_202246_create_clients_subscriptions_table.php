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
        Schema::create('clients_subscriptions', function (Blueprint $table) {
		$table->id();
		$table->string('email')->unique();
		$table->integer('palabras_maximas');
		$table->integer('numero_editores');
		$table->integer('numero_preguntas');
		$table->integer('numero_resumenes');
		$table->boolean('locucion_en_linea')->default(false);
		$table->string('otros_usuarios')->nullable();
		$table->integer('plan_contratado')->nullable();
		$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_subscriptions');
    }
};
