<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Contact information
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();

            // Profile information
            $table->text('bio')->nullable();
            $table->string('preferred_language')->default('en');
            $table->enum('profile_visibility', ['public', 'private'])->default('public');
            $table->date('birth_date')->nullable();

            // Geolocation data
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('service_radius', 8, 2)->nullable()->comment('Distance in kilometers');

            // Preferences
            $table->json('notification_preferences')->nullable();
            $table->json('preferred_payment_methods')->nullable();
            $table->json('favorite_categories')->nullable();
            $table->string('preferred_contact_time')->nullable();

            // Additional information
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('tax_identification')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_profiles');
    }
}
