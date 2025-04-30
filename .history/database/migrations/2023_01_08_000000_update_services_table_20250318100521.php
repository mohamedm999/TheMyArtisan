<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                // Add artisan_id column if it doesn't exist
                if (!Schema::hasColumn('services', 'artisan_id')) {
                    $table->unsignedBigInteger('artisan_id')->nullable()->after('id');

                    // If artisan_profile_id exists, copy its values to artisan_id
                    if (Schema::hasColumn('services', 'artisan_profile_id')) {
                        DB::statement('UPDATE services SET artisan_id = artisan_profile_id');
                    }

                    // Add index
                    $table->index('artisan_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'artisan_id')) {
                $table->dropIndex(['artisan_id']);
                $table->dropColumn('artisan_id');
            }
        });
    }
};
