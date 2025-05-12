<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['artisan_id']);
            $table->dropForeign(['customer_id']);

            // Rename columns
            $table->renameColumn('artisan_id', 'artisan_profile_id');
            $table->renameColumn('customer_id', 'client_profile_id');

            // Add new foreign keys
            $table->foreign('artisan_profile_id')->references('id')->on('artisan_profiles')->onDelete('cascade');
            $table->foreign('client_profile_id')->references('id')->on('client_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['artisan_profile_id']);
            $table->dropForeign(['client_profile_id']);

            // Rename columns back
            $table->renameColumn('artisan_profile_id', 'artisan_id');
            $table->renameColumn('client_profile_id', 'customer_id');

            // Add original foreign keys back
            $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
