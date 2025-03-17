<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTableV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
