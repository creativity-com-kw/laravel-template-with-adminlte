<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_id')->nullable();

            $table->integer('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_mobile')->nullable();
            $table->string('user_email')->nullable();

            $table->integer('coach_id')->nullable();
            $table->string('coach_name')->nullable();
            $table->string('coach_mobile')->nullable();
            $table->string('coach_email')->nullable();

            $table->integer('event_id')->nullable();
            $table->integer('event_schedule_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->integer('qr_code_id')->nullable();
            $table->integer('qr_code_image')->nullable();

            $table->integer('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_bookings');
    }
}
