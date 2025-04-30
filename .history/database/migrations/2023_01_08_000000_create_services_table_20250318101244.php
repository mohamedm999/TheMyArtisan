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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_profiles_id'); // Use consistent column name
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category');
            $table->decimal('price', 10, 2)->default(0);
            $table->integer('duration')->nullable()->comment('Duration in minutes');
            $table->boolean('is_available')->default(true);
            $table->timestamps();


            $table->foreignId('artisan_profile_id')->constrained()->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
