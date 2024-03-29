<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address', 50)->nullable()->change();
            $table->string('contact', 15)->nullable()->change();
            $table->string('e_certificate', 15)->nullable()->change();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->string('address', 50)->nullable()->change();
            $table->string('contact', 15)->nullable()->change();
        });

        Schema::table('form_answers', function (Blueprint $table) {
            $table->boolean('answer_true_false')->nullable()->change();
            $table->string('answer_multiple_choices', 1)->nullable()->change();
            $table->string('answer_text', 2000)->nullable()->change();
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->smallInteger('day_shift_limit')->default(0)->change();
            $table->smallInteger('noon_shift_limit')->default(0)->change();
            $table->smallInteger('night_shift_limit')->default(0)->change();
            $table->smallInteger('day_shift_registration')->default(0)->change();
            $table->smallInteger('noon_shift_registration')->default(0)->change();
            $table->smallInteger('night_shift_registration')->default(0)->change();
        });

        Schema::table('vaccinations', function (Blueprint $table) {
            $table->string('shot_name', 30)->nullable()->change();
        });

        Schema::table('vaccines', function (Blueprint $table) {
            $table->string('supplier', 50)->nullable()->change();
            $table->string('technology', 50)->nullable()->change();
            $table->string('country', 50)->nullable()->change();
            $table->boolean('is_allow')->default(false)->change();
        });

        Schema::table('vaccine_lots', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->change();
            $table->date('import_date')->default(date('Y-m-d'))->change();
            $table->date('expiry_date')->default(date('Y-m-d'))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
