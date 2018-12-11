<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_server', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('action_id');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');

            $table->unsignedInteger('server_id');
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');

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
        Schema::dropIfExists('action_server');
    }
}
