<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('vaccine_lot_id');
            $table->date('on_date');
            $table->smallInteger('day_shift_limit');
            $table->smallInteger('noon_shift_limit');
            $table->smallInteger('night_shift_limit');
            $table->smallInteger('day_shift_registration');
            $table->smallInteger('noon_shift_registration');
            $table->smallInteger('night_shift_registration');

            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->foreign('vaccine_lot_id')->references('id')->on('vaccine_lots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
