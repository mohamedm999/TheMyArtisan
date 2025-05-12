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
            $table->unsignedBigInteger('artisan_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->text('response')->nullable();
            $table->timestamp('response_date')->nullable();
            $table->boolean('reported')->default(false);
            $table->text('report_reason')->nullable();
            $table->timestamp('report_date')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();

            $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');

            // Add these indexes for better performance
            $table->index(['artisan_id', 'rating']);
            $table->index('status');

            // Add constraint to ensure rating is between 1-5
            $table->check('rating >= 1 AND rating <= 5');
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
