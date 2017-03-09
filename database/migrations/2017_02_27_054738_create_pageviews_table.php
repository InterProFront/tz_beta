<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageviewsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('pageviews', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('page_id');
//            $table->foreign('user_id')->references('id')->on('pages')->onDelete('cascade');
//            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedInteger('thread_last_number');
            $table->unsignedInteger('comment_last_number');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::drop('pageviews');
    }
}
