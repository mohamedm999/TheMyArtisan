<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnsureWorkExperiencesAndCertificationsTablesExist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('work_experiences')) {
            Schema::create('work_experiences', function (Blueprint $table) {
                $table->id();
                $table->foreignId('artisan_profile_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('company')->nullable();
                $table->string('location')->nullable();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->boolean('is_current')->default(false);
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('certifications')) {
            Schema::create('certifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('artisan_profile_id')->nullable()->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('issuing_organization');
                $table->date('issue_date');
                $table->date('expiry_date')->nullable();
                $table->string('credential_id')->nullable();
                $table->string('credential_url')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
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
        // We don't want to drop the tables in the down migration
        // since they might contain important data
    }
}
