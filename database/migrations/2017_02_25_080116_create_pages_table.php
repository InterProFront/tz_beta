<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('number');
            $table->string('slug')->unique();
            $table->boolean('deleted');
            $table->string('title');
            $table->string('description');
            $table->string('picture');
            $table->unsignedInteger('max_thread_number');
            $table->unsignedInteger('max_thread_index_number');
            $table->unsignedInteger('max_comment_number');
            $table->unsignedInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::drop('pages');
    }
}
