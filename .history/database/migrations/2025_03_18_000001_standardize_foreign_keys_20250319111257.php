<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Standardize foreign key column names across tables.
     *
     * @return void
     */
    public function up()
    {
        // Standardize work_experiences table
        if (Schema::hasTable('work_experiences') && Schema::hasColumn('work_experiences', 'user_id') && !Schema::hasColumn('work_experiences', 'artisan_profile_id')) {
            Schema::table('work_experiences', function (Blueprint $table) {
                // Add new column
                $table->unsignedBigInteger('artisan_profile_id')->nullable()->after('user_id');
            });

            // Copy data from user_id to artisan_profile_id via artisan_profiles
            DB::statement('
                UPDATE work_experiences w
                JOIN artisan_profiles a ON w.user_id = a.user_id
                SET w.artisan_profile_id = a.id
            ');

            // Make the column required after data migration
            Schema::table('work_experiences', function (Blueprint $table) {
                $table->unsignedBigInteger('artisan_profile_id')->nullable(false)->change();
                $table->foreign('artisan_profile_id')->references('id')->on('artisan_profiles')->onDelete('cascade');
            });
        }

        // Same approach for certifications
        if (Schema::hasTable('certifications') && Schema::hasColumn('certifications', 'user_id') && !Schema::hasColumn('certifications', 'artisan_profile_id')) {
            // Similar update for certifications table
            // ...
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverting these changes would be complex and potentially dangerous
        // Better to handle this manually if needed
    }
};
