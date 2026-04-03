<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('house_no');
            $table->string('house_type');
            $table->string('description')->nullable();
            $table->boolean('is_occupied')->default(0);
            $table->boolean('notice')->default(0);
            $table->decimal('rent_const', 15, 2)->default(0);
            $table->integer('rent_period')->default(1);
            $table->decimal('water_bill', 15, 2)->default(0);
            $table->decimal('garbage_bill', 15, 2)->default(0);
            $table->decimal('service_charge', 15, 2)->default(0);
            $table->unsignedBigInteger('apartment_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('apartment_id')
                ->references('id')->on('apartments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
