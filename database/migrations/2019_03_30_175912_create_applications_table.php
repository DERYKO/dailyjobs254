<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('applicant_id');
            $table->integer('job_owner_id');
            $table->text('cover_letter');
            $table->foreign('job_id')
                ->references('id')
                ->on('jobs');
            $table->foreign('owner_id')
                ->references('id')
                ->on('users');
            $table->foreign('applicant_id')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('applications');
    }
}
