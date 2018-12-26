<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashlinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashlinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('textbook_id')->unique();
            $table->string('hashlink')->unique();
            $table->string('orilink');
            $table->integer('click_time')->default(0);
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
        Schema::dropIfExists('hashlinks');
    }
}
