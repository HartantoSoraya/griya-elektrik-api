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
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->string('map');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('youtube');
            $table->integer('sort');
            $table->boolean('is_main')->default(false);
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
