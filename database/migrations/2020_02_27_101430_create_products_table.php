<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('sub_name');

            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();

            $table->string('type')->nullable();
            $table->string('bed_rooms')->nullable();
            $table->string('bath_rooms')->nullable();
            $table->string('car')->nullable();
            $table->string('sq')->nullable();
            $table->string('address')->nullable();
            $table->string('provide')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code')->nullable();
            $table->string('area')->nullable();
            $table->text('video')->nullable();

            $table->string('avatar')->default('products/no.png');
            $table->string('file')->default('products/no.png');

            $table->longText('summary');

            $table->integer('language_id')->unsigned()->index();
            $table->foreign('language_id')->references('id')->on('language')->onDelete('cascade');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}
