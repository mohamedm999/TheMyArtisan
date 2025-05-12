<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToArtisanProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            // Check if the column doesn't exist before adding
            if (!Schema::hasColumn('artisan_profiles', 'status')) {
                $table->string('status')->default('approved')->after('service_radius');
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
            if (Schema::hasColumn('artisan_profiles', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
