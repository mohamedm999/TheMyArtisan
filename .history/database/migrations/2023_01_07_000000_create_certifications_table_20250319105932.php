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
            Schema::create('certifications', function (Blueprint $table) {
                $table->id();

                $table->string('name');
                $table->string('issuer');
                $table->date('valid_until')->nullable();
                $table->string('credential_id')->nullable();
                $table->string('credential_url')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
    
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
