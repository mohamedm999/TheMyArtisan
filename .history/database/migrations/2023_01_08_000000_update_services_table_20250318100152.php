<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Check if the artisan_id column doesn't exist
            if (!Schema::hasColumn('services', 'artisan_id')) {
                // Add artisan_id column
                $table->unsignedBigInteger('artisan_id')->nullable()->after('id');

                // Add foreign key if artisan_profiles table exists
                if (Schema::hasTable('artisan_profiles')) {
                    $table->foreign('artisan_id')
                        ->references('id')
                        ->on('artisan_profiles')
                        ->onDelete('cascade');
                }
            }

            // Also add artisan_profiles_id if it doesn't exist (for consistency with other tables)
            if (!Schema::hasColumn('services', 'artisan_profiles_id')) {
                $table->unsignedBigInteger('artisan_profiles_id')->nullable()->after('artisan_id');

                // Add foreign key if artisan_profiles table exists
                if (Schema::hasTable('artisan_profiles')) {
                    $table->foreign('artisan_profiles_id')
                        ->references('id')
                        ->on('artisan_profiles')
                        ->onDelete('cascade');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Drop foreign keys first (if they exist)
            if (Schema::hasColumn('services', 'artisan_profiles_id')) {
                $table->dropForeign(['artisan_profiles_id']);
                $table->dropColumn('artisan_profiles_id');
            }

            if (Schema::hasColumn('services', 'artisan_id')) {
                $table->dropForeign(['artisan_id']);
                $table->dropColumn('artisan_id');
            }
        });
    }
};
