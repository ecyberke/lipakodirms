<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgencyexpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencyexpenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_agent');
            $table->string('description');
            $table->string('phone_number');
            $table->decimal('amount_spent',15,2);
            $table->string('files');
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
        Schema::dropIfExists('agencyexpenses');
    }
}
