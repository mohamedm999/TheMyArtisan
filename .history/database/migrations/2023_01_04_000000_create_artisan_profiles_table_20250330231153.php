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
        Schema::create('artisan_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('profession')->nullable();
            $table->text('about_me')->nullable();
            $table->json('skills')->nullable();
            $table->unsignedInteger('experience_years')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('location_coordinates')->nullable();
            $table->json('availability_hours')->nullable();
            $table->string('business_name')->nullable();
            $table->string('business_registration_number')->nullable();
            $table->text('insurance_details')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('profile_photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisan_profiles');
    }
};
