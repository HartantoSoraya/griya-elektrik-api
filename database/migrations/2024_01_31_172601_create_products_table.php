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
            $table->uuid('id')->primary();
            $table->string('code');
            $table->uuid('product_category_id');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->uuid('product_brand_id');
            $table->foreign('product_brand_id')->references('id')->on('product_brands')->onDelete('cascade');
            $table->string('name');
            $table->string('thumbnail');
            $table->longText('description');
            $table->decimal('price');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('slug')->unique();
            $table->softDeletes();
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
