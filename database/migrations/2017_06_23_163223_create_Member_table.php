<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Member', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('package_id');
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('username', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account_number', 100)->nullable();
            $table->string('bank_account_holder', 255)->nullable();
            $table->string('identification_number', 255)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->string('date_of_birth', 100)->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->smallInteger('level')->default(1);
            $table->decimal('package_amount', 16, 4)->default(0);
            $table->decimal('cash_wallet', 16, 4)->default(0);
            $table->decimal('roi_wallet', 16, 4)->default(0);
            $table->decimal('current_roi', 16, 4)->default(0);
            $table->decimal('register_wallet', 16, 4)->default(0);
            $table->decimal('direct', 16, 4)->default(0);
            $table->decimal('roi', 16, 4)->default(0);
            $table->decimal('max_profit', 16, 4)->default(0);
            $table->boolean('is_active')->default(0);
            $table->boolean('is_ban')->default(0);
            $table->timestamp('next_roi')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Member');
    }
}
