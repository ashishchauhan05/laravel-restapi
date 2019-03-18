<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMachinePerformanceLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('machine_performance_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machine_id')->unsigned();
            $table->date('date');
            $table->time('start');
            $table->time('stop');
            $table->time('duration');
            $table->time('cumulative');
            $table->time('loss');
            $table->time('cumulative_loss');
            $table->integer('client_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('api_clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('machine_performance_logs', function(Blueprint $table){
            $table->dropForeign(['client_id']);
        });
        Schema::dropIfExists('machine_performance_logs');
    }
}
