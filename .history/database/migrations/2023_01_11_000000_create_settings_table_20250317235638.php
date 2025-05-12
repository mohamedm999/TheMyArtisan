<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        $settings = [
            ['key' => 'site_name', 'value' => 'MyArtisan'],
            ['key' => 'contact_email', 'value' => 'contact@myartisan.com'],
            ['key' => 'site_description', 'value' => 'Your trusted platform for finding quality artisans and services.'],
            ['key' => 'commission_rate', 'value' => '10'],
            ['key' => 'tax_rate', 'value' => '20'],
        ];

        DB::table('settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
