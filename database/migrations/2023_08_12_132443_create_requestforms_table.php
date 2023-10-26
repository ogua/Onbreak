<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestforms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('prvider_id');
            $table->string('service')->nullable();
            $table->text('note')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('requestforms');
    }
}
