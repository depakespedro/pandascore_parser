<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOpponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opponents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('match_id')->unsigned();
            $table->foreign('match_id')->references('id')->on('matches');

            $table->unsignedBigInteger('opponentsable_id')->unsigned();
            $table->string('opponentsable_type', 64);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opponents');
    }
}
