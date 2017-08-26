<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Package', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package_amount', 16, 4)->default(0);
            $table->decimal('direct', 16, 4)->default(0);
            $table->decimal('roi', 16, 4)->default(0);
            $table->decimal('max_profit', 16, 4)->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Package');
    }
}
