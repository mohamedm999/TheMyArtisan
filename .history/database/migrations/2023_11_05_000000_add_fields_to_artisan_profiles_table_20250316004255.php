<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToArtisanProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artisan_profiles', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('artisan_profiles', 'profession')) {
                $table->string('profession')->nullable();
            }
            if (!Schema::hasColumn('artisan_profiles', 'about_me')) {
                $table->text('about_me')->nullable();
            }
            if (!Schema::hasColumn('artisan_profiles', 'skills')) {
                $table->json('skills')->nullable();
            }
            if (!Schema::hasColumn('artisan_profiles', 'experience_years')) {
                $table->integer('experience_years')->default(0);
            }
            if (!Schema::hasColumn('artisan_profiles', 'hourly_rate')) {
                $table->decimal('hourly_rate', 10, 2)->default(0);
            }
            if (!Schema::hasColumn('artisan_profiles', 'country')) {
                $table->string('country')->nullable();
            }
            if (!Schema::hasColumn('artisan_profiles', 'business_registration_number')) {
                $table->string('business_registration_number')->nullable();
            }
            if (!Schema::hasColumn('artisan_profiles', 'insurance_details')) {
                $table->text('insurance_details')->nullable();
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
            $table->dropColumn([
                'profession',
                'about_me',
                'skills',
                'experience_years',
                'hourly_rate',
                'country',
                'business_registration_number',
                'insurance_details'
            ]);
        });
    }
}
