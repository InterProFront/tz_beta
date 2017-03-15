<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('number');
            $table->unsignedInteger('index_number');
            $table->boolean('deleted');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('max_comment_number');
            $table->unsignedSmallInteger('top');
            $table->unsignedSmallInteger('left');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('author_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->timestamp('self_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('threads');
    }
}
