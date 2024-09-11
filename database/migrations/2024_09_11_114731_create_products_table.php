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
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->json('name');
            $table->json('description');
            $table->json('ingredients')->nullable();
            $table->json('how_to_prepare')->nullable();
            $table->boolean('is_unlimited')->default(false);
            $table->string('main_image');
            $table->text('images');
            $table->integer('quantity');
            $table->double('price');
            $table->text('options_ids')->nullable();
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
