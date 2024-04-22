<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpVaccineLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vaccine_lots', function (Blueprint $table) {
            $table->unique(['business_id', 'lot'], 'business_id_vaccine_lot_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vaccine_lots', function (Blueprint $table) {
            $table->dropUnique('business_id_vaccine_lot_unique');
        });
    }
}
