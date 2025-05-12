<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            // ...existing code...

            // Add fulltext index for better search functionality
            $table->fullText(['name', 'description']);

            // Add index for common filtering scenarios
            $table->index(['artisan_id', 'is_active']);
        });
    }

    // ...existing code...
}
