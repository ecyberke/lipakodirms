<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('landlord_id')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('town');
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->double('management_fee_percentage');
            $table->timestamps();

            $table->foreign('landlord_id')
                ->references('id')->on('landlords')
                ->onDelete('set null')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
