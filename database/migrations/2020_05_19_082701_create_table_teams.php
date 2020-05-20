<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTeams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->comment('Внешний id команды из системы pandascore.co');
            $table->string('name', 256)->comment('Название команды');
            $table->string('acronym', 64)->nullable();
            $table->string('slug', 256)->nullable();
            $table->char('location', 2)->nullable();
            $table->string('image_url', 512)->nullable();
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
        Schema::dropIfExists('teams');
    }
}
