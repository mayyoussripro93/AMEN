<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Staff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('employees', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->date('date_of_birth')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->string('national_id_card_number')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_num')->nullable();
            $table->string('job_title')->nullable();
            $table->text('street_address')->nullable();
            $table->integer('is_active')->nullable()->default(0);
            $table->boolean('verified')->default(0);
            $table->string('verification_token')->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('image')->nullable();
            $table->string('employee_role_id')->nullable();
            $table->integer('is_manager')->nullable();
            $table->timestamps();

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
        Schema::drop('employees');
    }
}
