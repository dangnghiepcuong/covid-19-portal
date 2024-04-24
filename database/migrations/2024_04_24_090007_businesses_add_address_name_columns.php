<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BusinessesAddAddressNameColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('addr_province_name', 100)->after('addr_province');
            $table->string('addr_district_name', 100)->after('addr_district');
            $table->string('addr_ward_name', 100)->after('addr_ward');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('addr_province_name');
            $table->dropColumn('addr_district_name');
            $table->dropColumn('addr_ward_name');
        });
    }
}
