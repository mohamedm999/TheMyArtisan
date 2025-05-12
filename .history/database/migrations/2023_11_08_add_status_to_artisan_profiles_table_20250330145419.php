<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToArtisanProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('artisan_profiles', 'status')) {
                $table->string('status')->default('pending')->after('service_radius');
            }

            // Also add the specialty column if it doesn't exist
            if (!Schema::hasColumn('artisan_profiles', 'specialty')) {
                $table->string('specialty')->nullable()->after('status');
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

            if (Schema::hasColumn('artisan_profiles', 'specialty')) {
                $table->dropColumn('specialty');
            }
        });
    }
}
