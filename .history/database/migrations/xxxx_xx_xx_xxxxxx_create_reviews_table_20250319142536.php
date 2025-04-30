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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_profile_id')->nullable()->constrained('artisan_profiles')->onDelete('set null');
            $table->foreignId('artisan_profile_id')->nullable()->constrained('artisan_profiles')->onDelete('set null');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('rating')->unsigned()->comment('Rating from 1-5');
            $table->text('comment')->nullable();
            $table->text('response')->nullable();
            $table->timestamp('response_date')->nullable();
            $table->boolean('reported')->default(false)->index();
            $table->text('report_reason')->nullable();
            $table->timestamp('report_date')->nullable();
            $table->enum('status', ['published', 'pending', 'rejected', 'hidden'])->default('published')->index();
            $table->boolean('is_verified_purchase')->default(true);
            $table->integer('helpful_count')->default(0);
            $table->boolean('is_featured')->default(false)->index();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['artisan_id', 'status']);
            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
