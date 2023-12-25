<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('survey_id')->nullable();
            $table->foreign('survey_id')->references('id')->on('surveys');
            $table->unsignedInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections');
            $table->unsignedBigInteger('dimension_id')->nullable();
            $table->foreign('dimension_id')->references('id')->on('dimensions');
            $table->unsignedBigInteger('question_type_id')->nullable();
            $table->foreign('question_type_id')->references('id')->on('question_types');
            $table->string('content');
            $table->string('type')->default('text');
            $table->json('options')->nullable();
            $table->json('rules')->nullable();
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
        Schema::dropIfExists(config('survey.database.tables.questions'));
    }
}
