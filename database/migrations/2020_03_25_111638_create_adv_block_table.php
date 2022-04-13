<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvBlockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adv_block', function (Blueprint $table) {
            $table->increments('id');
            $table->longText("adv_blog_1")->nullable();
            $table->longText("adv_blog_2")->nullable();
            $table->longText("adv_blog_view_1")->nullable();
            $table->longText("adv_blog_view_2")->nullable();
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
        Schema::dropIfExists('adv_block');
    }
}
