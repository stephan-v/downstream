<?php

use App\Job;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('output')->nullable();
            $table->text('commands');

            $table->unsignedTinyInteger('status')->default(Job::PENDING);

            $table->unsignedInteger('server_id');
            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');

            $table->unsignedInteger('deployment_id');
            $table->foreign('deployment_id')->references('id')->on('deployments')->onDelete('cascade');

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
        Schema::dropIfExists('jobs');
    }
}
