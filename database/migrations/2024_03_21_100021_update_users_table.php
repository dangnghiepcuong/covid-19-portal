<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');

            $table->unsignedBigInteger('account_id');
            $table->softDeletes();
            $table->string('pid', 20)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday');
            $table->string('gender', 15);
            $table->string('addr_province', 30);
            $table->string('addr_district', 30);
            $table->string('addr_ward', 30);
            $table->string('address', 50);
            $table->string('contact', 15);
            $table->string('e_certificate', 15);
            
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->index(['last_name', 'first_name']);
            $table->index('first_name');
            $table->index('contact');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
        });
    }
}
