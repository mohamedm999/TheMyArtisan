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
        // MySQL requires dropping and recreating the enum
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE artisan_profiles MODIFY status ENUM('active', 'approved', 'rejected', 'pending') DEFAULT 'active'");
        }
        // PostgreSQL can use type modification
        else if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE artisan_profiles DROP CONSTRAINT IF EXISTS artisan_profiles_status_check");
            DB::statement("ALTER TABLE artisan_profiles ADD CONSTRAINT artisan_profiles_status_check CHECK (status IN ('active', 'approved', 'rejected', 'pending'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE artisan_profiles MODIFY status ENUM('active', 'approved', 'rejected') DEFAULT 'active'");
        }
        else if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE artisan_profiles DROP CONSTRAINT IF EXISTS artisan_profiles_status_check");
            DB::statement("ALTER TABLE artisan_profiles ADD CONSTRAINT artisan_profiles_status_check CHECK (status IN ('active', 'approved', 'rejected'))");
        }
    }
};
