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
        if (!Schema::hasTable('work_experiences')) {
            Schema::create('work_experiences', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('artisan_profiles_id'); // Use consistent column name
                $table->unsignedBigInteger('user_id');
                $table->string('position');
                $table->string('company_name')->nullable();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->boolean('is_current')->default(false);
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('artisan_profiles_id')
                    ->references('id')
                    ->on('artisan_profiles')
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
