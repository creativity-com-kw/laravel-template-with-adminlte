<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_id')->nullable();
            $table->tinyInteger('module')->nullable()->comment('1 = spinning cycle, 2 = personal training, 3 = group class');
            $table->tinyInteger('type')->nullable()->comment('1 = class seat, 2 = class schedule, 3 = event seat, 4 = package');
            $table->integer('reference_no')->nullable();
            $table->integer('subscription_id')->nullable();

            $table->integer('package_id')->nullable();
            $table->string('package_name')->nullable();
            $table->text('package_description')->nullable();
            $table->integer('package_duration')->nullable();
            $table->integer('package_num_classes')->nullable();
            $table->integer('package_validity')->nullable();
            $table->string('package_validity_label')->nullable();
            $table->dateTime('package_start_date')->nullable();
            $table->dateTime('package_end_date')->nullable();
            $table->decimal('package_amount',10,3)->nullable();

            $table->integer('class_id')->nullable();
            $table->string('class_name')->nullable();
            $table->text('class_description')->nullable();
            $table->integer('class_num_seats')->nullable();
            $table->decimal('class_seat_price',10,3)->nullable();
            $table->decimal('class_floor_price',10,3)->nullable();
            $table->integer('class_duration')->nullable();
            $table->string('class_duration_label')->nullable();
            $table->tinyInteger('class_app_visibility')->nullable();

            $table->integer('event_id')->nullable();
            $table->string('event_name')->nullable();
            $table->text('event_description')->nullable();
            $table->text('event_address')->nullable();
            $table->text('event_latitude')->nullable();
            $table->text('event_longitude')->nullable();
            $table->integer('event_num_seats')->nullable();
            $table->decimal('event_price',10,3)->nullable();
            $table->integer('event_duration')->nullable();
            $table->integer('event_coach_id')->nullable();

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
        Schema::dropIfExists('invoice_items');
    }
}
