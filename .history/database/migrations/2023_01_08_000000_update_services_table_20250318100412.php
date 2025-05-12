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
        // First check if the services table exists
        if (Schema::hasTable('services')) {
            // Check current columns
            $columns = Schema::getColumnListing('services');
            
            // Apply changes if needed
            Schema::table('services', function (Blueprint $table) use ($columns) {
                // Add artisan_id if it doesn't exist
                if (!in_array('artisan_id', $columns)) {
                    $table->unsignedBigInteger('artisan_id')->nullable()->after('id');
                    
                    // Add foreign key if artisan_profiles table exists
                    if (Schema::hasTable('artisan_profiles')) {
                        try {
                            $table->foreign('artisan_id')
                                ->references('id')
                                ->on('artisan_profiles')
                                ->onDelete('cascade');
                        } catch (\Exception $e) {
                            // Log error but continue
                            DB::statement('ALTER TABLE services ADD INDEX artisan_id_index (artisan_id)');
                        }
                    }
                }
                
                // Add artisan_profiles_id if it doesn't exist
                if (!in_array('artisan_profiles_id', $columns)) {
                    $table->unsignedBigInteger('artisan_profiles_id')->nullable()->after('id');
                    
                    // Add foreign key if artisan_profiles table exists
                    if (Schema::hasTable('artisan_profiles')) {
                        try {
                            $table->foreign('artisan_profiles_id')
                                ->references('id')
                                ->on('artisan_profiles')
                                ->onDelete('cascade');
                        } catch (\Exception $e) {
                            // Log error but continue
                            DB::statement('ALTER TABLE services ADD INDEX artisan_profiles_id_index (artisan_profiles_id)');
                        }
                    }
                }
            });
        } else {
            // Create a simple services table since it doesn't exist yet
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('artisan_id')->nullable();
                $table->unsignedBigInteger('artisan_profiles_id')->nullable();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->integer('duration')->nullable(); // in minutes
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                // Add foreign keys
                if (Schema::hasTable('artisan_profiles')) {
                    $table->foreign('artisan_id')
                        ->references('id')
                        ->on('artisan_profiles')
                        ->onDelete('cascade');
                        
                    $table->foreign('artisan_profiles_id')
                        ->references('id')
                        ->on('artisan_profiles')
                        ->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('services')) {
            Schema::table('services', function (Blueprint $table) {
                // Remove foreign keys if they exist
                try {
                    if (Schema::hasColumn('services', 'artisan_profiles_id')) {
                        $table->dropForeign(['artisan_profiles_id']);
                    }
                } catch (\Exception $e) {
                    // Ignore errors if constraint doesn't exist
                }
                
                try {
                    if (Schema::hasColumn('services', 'artisan_id')) {
                        $table->dropForeign(['artisan_id']);
                    }
                } catch (\Exception $e) {
                    // Ignore errors if constraint doesn't exist
                }
                
                // Drop columns
                if (Schema::hasColumn('services', 'artisan_profiles_id')) {
                    $table->dropColumn('artisan_profiles_id');
                }
                
                if (Schema::hasColumn('services', 'artisan_id')) {
                    $table->dropColumn('artisan_id');
                }
            });
        }
    }
};
