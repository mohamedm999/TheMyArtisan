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
        Schema::create('artisan_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('artisan_id')
                  ->references('id')
                  ->on('artisans')
                  ->onDelete('cascade');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

            $table->unique(['artisan_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_category');
    }
};
