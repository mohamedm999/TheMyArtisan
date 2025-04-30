<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixWorkExperienceForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table exists and has the wrong column name
        if (Schema::hasTable('work_experiences') && Schema::hasColumn('work_experiences', 'artisan_profiles_id')) {
            Schema::table('work_experiences', function (Blueprint $table) {
                // Rename the column
                $table->renameColumn('artisan_profiles_id', 'artisan_profile_id');
            });
        }
        // If the table exists but doesn't have either column, add the correct one
        else if (Schema::hasTable('work_experiences') &&
                !Schema::hasColumn('work_experiences', 'artisan_profiles_id') &&
                !Schema::hasColumn('work_experiences', 'artisan_profile_id')) {
            Schema::table('work_experiences', function (Blueprint $table) {
                $table->unsignedBigInteger('artisan_profile_id')->nullable();
                $table->foreign('artisan_profile_id')->references('id')->on('artisan_profiles')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('work_experiences') && Schema::hasColumn('work_experiences', 'artisan_profile_id')) {
            Schema::table('work_experiences', function (Blueprint $table) {
                $table->renameColumn('artisan_profile_id', 'artisan_profiles_id');
            });
        }
    }
}
