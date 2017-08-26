<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTakeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Take', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->decimal('amount', 16, 4);
            $table->string('status', 25)->nullable();
            $table->string('type', 25)->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('member_id');
            $table->index(['status', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Take');
    }
}
