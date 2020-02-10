<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('projects', function(Blueprint $table)
        {   $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('owner');
            $table->text('description');
            $table->date('higri_start_date')->nullable();
            $table->date('date_gregorian');
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
        Schema::drop('projects');
    }
}
