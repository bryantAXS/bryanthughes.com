<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string("subtitle");
            $table->text("paragraph_1");
            $table->text("paragraph_2");
            $table->string("slug");
            $table->string("latest_published_version");
            $table->string("post_date");
            $table->string("medium_url");
            $table->json("json");
            $table->string("article_id");
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
        Schema::drop('articles');
    }
}
