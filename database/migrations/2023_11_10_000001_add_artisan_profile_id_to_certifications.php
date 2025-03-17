<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArtisanProfileIdToCertifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('certifications') && !Schema::hasColumn('certifications', 'artisan_profile_id')) {
            Schema::table('certifications', function (Blueprint $table) {
                $table->foreignId('artisan_profile_id')->after('id')->nullable()->constrained()->onDelete('cascade');
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
        if (Schema::hasTable('certifications') && Schema::hasColumn('certifications', 'artisan_profile_id')) {
            Schema::table('certifications', function (Blueprint $table) {
                $table->dropForeign(['artisan_profile_id']);
                $table->dropColumn('artisan_profile_id');
            });
        }
    }
}
