<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('in_page_number');
            $table->unsignedInteger('in_thread_number');
            $table->boolean('deleted');
            $table->string('slug')->unique();
            $table->string('description');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('thread_id');
            $table->unsignedInteger('author_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('page_id')->references('id')->on('pages');
            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users');
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
        Schema::drop('comments');
    }
}
