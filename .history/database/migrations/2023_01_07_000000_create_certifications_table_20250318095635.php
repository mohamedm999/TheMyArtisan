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
        if (!Schema::hasTable('certifications')) {
            Schema::create('certifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('artisan_profiles_id'); // Use consistent column name
                $table->unsignedBigInteger('user_id');
                $table->string('name'); // Store the certification name
                $table->string('issuer'); // Store the issuing organization
                $table->date('valid_until')->nullable(); // Expiry date
                $table->string('credential_id')->nullable();
                $table->string('credential_url')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('artisan_profiles_id')
                    ->references('id')
                    ->on('artisan_profiles')
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
