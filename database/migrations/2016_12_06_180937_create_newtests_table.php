<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('question_test');
        Schema::dropIfExists('tests');
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            if (config('database.default') == 'pgsql')
                $table->timestamp('ended_at')->default("1000-01-01 00:00:00");
            else
                $table->timestamp('ended_at');

            $table->string('tagtype');
            $table->integer('totalnumber')->default(5);
            $table->integer('testtype')->default(0);
            $table->integer('point')->default(-1);
            $table->integer('user_id');
            $table->text('questionids')->nullable();
            $table->text('useranswer')->nullable();
            $table->text('judges')->nullable();

        });

        Schema::create('question_test', function (Blueprint $table) {
            $table->integer('question_id')->unsigned()->index();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->integer('test_id')->unsigned()->index();
            $table->foreign('test_id')->references('id')->on('tests');
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
        Schema::drop('question_test');
        Schema::drop('tests');
    }
}
