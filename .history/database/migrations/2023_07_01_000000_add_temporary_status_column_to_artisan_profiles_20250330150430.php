<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class AddTemporaryStatusColumnToArtisanProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            // Add temporary status column if it doesn't exist already
            if (!Schema::hasColumn('artisan_profiles', 'status')) {
                Schema::table('artisan_profiles', function (Blueprint $table) {
                    $table->string('status')->default('approved')->after('is_available');
                });

                Log::info('Temporary status column added to artisan_profiles table');
            }
        } catch (\Exception $e) {
            Log::error('Error adding temporary status column: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Don't remove the column in down migration since it might be
        // used by other parts of the system
    }
}
