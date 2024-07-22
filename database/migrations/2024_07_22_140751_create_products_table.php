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
        Schema::create('products', function (Blueprint $table) {
		$table->id();
		$table->string('name');
		$table->string('type');
		$table->integer('quantity');
		$table->decimal('price', 8, 2); // 8 dígitos en total, 2 decimales
		$table->string('stripe_product_id');
		$table->boolean('is_active')->default(true);
		$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
