<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_cases', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->unsigned();
            $table->string('project_member_id');
            $table->string('name', 255);
            $table->string('detail', 255);
            $table->string('status')->default("new");
            $table->dateTime('start_case_time')->nullable();
            $table->dateTime('end_case_time')->nullable();
            $table->dateTime('open_case_time')->nullable();
            $table->dateTime('done_case_time')->nullable();
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
        Schema::dropIfExists('project_case_models');
    }
}
