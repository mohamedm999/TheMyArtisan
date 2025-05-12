<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialtyStatusToArtisanProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('artisan_profiles', 'specialty')) {
                $table->string('specialty')->nullable();
            }

            if (!Schema::hasColumn('artisan_profiles', 'speciality')) {
                $table->string('speciality')->nullable();
            }

            if (!Schema::hasColumn('artisan_profiles', 'status')) {
                $table->string('status')->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            $table->dropColumn(['specialty', 'speciality', 'status']);
        });
    }
}
