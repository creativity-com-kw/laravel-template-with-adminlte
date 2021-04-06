<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('civil_id_number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->tinyInteger('gender')->nullable()->comment('1 = male, 2 = female');
            $table->string('password',700)->nullable();
            $table->tinyInteger('status')->nullable()->comment('1 = pending, 2 = accepted, 3 = rejected');
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
        Schema::dropIfExists('coach_applications');
    }
}
