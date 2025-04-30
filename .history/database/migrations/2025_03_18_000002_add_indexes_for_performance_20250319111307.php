<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add performance indexes to frequently queried tables.
     *
     * @return void
     */
    public function up()
    {
        // Add indexes to bookings table
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Indexes for common filtering operations
                $table->index(['artisan_id', 'status']);
                $table->index(['customer_id', 'status']);
                $table->index(['service_id']);
                $table->index(['created_at']);
            });
        }

        // Add indexes to artisan_profiles table
        if (Schema::hasTable('artisan_profiles')) {
            Schema::table('artisan_profiles', function (Blueprint $table) {
                // For geographic searches
                $table->index(['city', 'state', 'postal_code']);

                // For verification filtering
                $table->index('is_verified');
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
        // Remove added indexes
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropIndex(['artisan_id', 'status']);
                $table->dropIndex(['customer_id', 'status']);
                $table->dropIndex(['service_id']);
                $table->dropIndex(['created_at']);
            });
        }

        if (Schema::hasTable('artisan_profiles')) {
            Schema::table('artisan_profiles', function (Blueprint $table) {
                $table->dropIndex(['city', 'state', 'postal_code']);
                $table->dropIndex(['is_verified']);
            });
        }
    }
};
