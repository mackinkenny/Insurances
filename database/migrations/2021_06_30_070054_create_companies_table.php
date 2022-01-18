<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
            $table->unsignedInteger('country_id');
            $table->string('city');
            $table->string('tax_id');
            $table->string('phone');
            $table->unsignedInteger('type');
            $table->integer('user_id');
            $table->bigInteger('parent_id')->nullable();
            $table->string('logo')->nullable();
            $table->string('example')->nullable();
            $table->integer('tokens_count')->default(0);
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
        Schema::dropIfExists('companies');
    }
}
