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
            $table->integer('project_member_id')->unsigned();
            $table->string('name', 255);
            $table->string('detail', 255);
            $table->string('status')->default("new");
            $table->dateTime('start_case_date')->nullable();
            $table->dateTime('end_case_date')->nullable();
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
