<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrophiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trophies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('psn_trophy_id');
            $table->integer('trophy_group_id');
            $table->integer('game_id');
            $table->string('name');
            $table->enum('type', ['bronze', 'silver', 'gold', 'platinum']);
            $table->text('description');
            $table->text('icon_url');
            $table->boolean('earned');
            $table->timestamp('earned_date')->nullable();
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
        Schema::dropIfExists('trophies');
    }
}
