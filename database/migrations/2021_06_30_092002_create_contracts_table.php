<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->text('encrypt_number');
            $table->string('policy_number');
            $table->string('ip_address');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('country_id');
            $table->bigInteger('company_id');
            $table->bigInteger('upload_id')->nullable();
            $table->boolean('api');
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
        Schema::dropIfExists('contracts');
    }
}
