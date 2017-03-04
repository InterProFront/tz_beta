<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('number');
            $table->string('slug')->unique();
            $table->boolean('deleted');
            $table->string('title');
            $table->string('description');
            $table->unsignedInteger('max_page_number');
            $table->unsignedInteger('max_member_number');
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
        Schema::drop('projects');
    }
}
