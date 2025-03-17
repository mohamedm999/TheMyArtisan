<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixWorkExpCertifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ensure artisan_profiles table exists and has an ID column
        if (!Schema::hasTable('artisan_profiles')) {
            Schema::create('artisan_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->timestamps();
            });
        }

        // Recreate work_experiences table with the proper structure
        Schema::dropIfExists('work_experiences');
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_profile_id');
            $table->string('title');
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('artisan_profile_id')
                ->references('id')
                ->on('artisan_profiles')
                ->onDelete('cascade');
        });

        // Recreate certifications table with the proper structure
        Schema::dropIfExists('certifications');
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_profile_id');
            $table->string('title');
            $table->string('issuing_organization');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('credential_id')->nullable();
            $table->string('credential_url')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('artisan_profile_id')
                ->references('id')
                ->on('artisan_profiles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_experiences');
        Schema::dropIfExists('certifications');
    }
}
