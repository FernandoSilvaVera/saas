<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->integer('word_limit');
            $table->integer('test_questions_count');
            $table->integer('summaries');
            $table->boolean('voiceover');
            $table->integer('editors_count');
            $table->decimal('monthly_price', 8, 2);
            $table->decimal('annual_price', 8, 2);
            $table->text('description');
            $table->string('stripe_product_id');
            $table->string('stripe_monthly_price_id');
            $table->string('stripe_annual_price_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
