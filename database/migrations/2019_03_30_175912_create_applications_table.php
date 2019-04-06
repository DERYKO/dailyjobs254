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
            $table->integer('job_id')->unsigned();
            $table->integer('applicant_id')->unsigned();
            $table->integer('job_owner_id')->unsigned();
            $table->text('cover_letter');
            $table->foreign('job_id')
                ->references('id')
                ->on('jobs')
                ->onUpdate('cascade');
             $table->foreign('job_owner_id')
                 ->references('id')
                 ->on('users')
                 ->onUpdate('cascade')
                 ->onDelete('restrict');
            $table->foreign('applicant_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
