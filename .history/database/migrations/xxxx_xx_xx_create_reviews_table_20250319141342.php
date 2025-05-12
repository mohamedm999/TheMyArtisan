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
            $table->unsignedBigInteger('artisan_profile_id'); // Changed from artisan_id
            $table->unsignedBigInteger('client_profile_id'); // Changed from customer_id
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

            $table->foreign('artisan_profile_id')->references('id')->on('artisan_profiles')->onDelete('cascade');
            $table->foreign('client_profile_id')->references('id')->on('client_profiles')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('set null');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
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
