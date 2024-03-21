<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('tax_id', 12)->unique();
            $table->string('name', 128);
            $table->string('addr_province', 30);
            $table->string('addr_district', 30);
            $table->string('addr_ward', 30);
            $table->string('address', 50);
            $table->string('contact', 15);
            
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->index('name');
            $table->index('tax_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
