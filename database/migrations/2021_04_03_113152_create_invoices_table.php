<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('module')->nullable()->comment('1 = spinning cycle, 2 = personal training, 3 = group class');
            $table->tinyInteger('type')->nullable()->comment('1 = class seat, 2 = class schedule, 3 = event seat, 4 = package');
            $table->integer('reference_no')->nullable();
            $table->integer('payment_mode')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->decimal('total_amount',10,3)->nullable();
            $table->decimal('discount_amount',10,3)->nullable();
            $table->decimal('paid_amount',10,3)->nullable();
            $table->integer('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 = pending, 2 = paid, 3 = cancelled, 4 = failed');
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
        Schema::dropIfExists('invoices');
    }
}
