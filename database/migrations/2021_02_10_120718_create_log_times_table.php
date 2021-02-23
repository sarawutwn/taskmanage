<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_times', function (Blueprint $table) {
            $table->id();
            $table->integer('project_case_id')->unsigned();
            $table->string('detail', 255)->nullable();
            $table->DateTime('work_start_time')->nullable();
            $table->DateTime('work_end_time')->nullable();
            $table->string('total_working_time')->nullable();
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
        Schema::dropIfExists('log_times');
    }
}
