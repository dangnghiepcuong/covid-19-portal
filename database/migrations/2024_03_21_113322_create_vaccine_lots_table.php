<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccineLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccine_lots', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedSmallInteger('vaccine_id');
            $table->string('lot', 30);
            $table->unsignedBigInteger('business_id');
            $table->integer('quantity');
            $table->date('import_date');
            $table->date('expiry_date');
            
            $table->foreign('vaccine_id')->references('id')->on('vaccines');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccine_lots');
    }
}
