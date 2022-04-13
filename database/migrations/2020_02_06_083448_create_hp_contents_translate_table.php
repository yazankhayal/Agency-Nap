<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHpContentsTranslateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hp_contents_translate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('sub_name')->nullable();
            $table->longText('sub_summary')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('summary1')->nullable();
            $table->longText('sub_summary2')->nullable();
            $table->integer('language_id')->unsigned()->index();
            $table->integer('hp_contents_id')->unsigned()->index();
            $table->foreign('language_id')->references('id')->on('language')->onDelete('cascade');
            $table->foreign('hp_contents_id')->references('id')->on('hp_contents')->onDelete('cascade');
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
        Schema::dropIfExists('hp_contents_translate');
    }
}
