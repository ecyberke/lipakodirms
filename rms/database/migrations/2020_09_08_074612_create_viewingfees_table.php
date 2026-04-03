<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewingfeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewingfees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apartment_id');
            $table->string('agent_name');
            $table->string('tenant_name');
            $table->string('phone_number');
            $table->decimal('viewing_amount',15,2);
            $table->timestamps();

            $table->foreign('apartment_id')
            ->references('id')->on('apartments')
            ->onDelete('cascade')
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
        Schema::dropIfExists('viewingfees');
    }
}
