<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('full_name');           
            $table->string('email');
            $table->string('phone_no');
            $table->string('password');
            $table->string('physical_address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('occupied_at')->nullable();
            $table->string('job_contact')->nullable();
            $table->string('emergency_person')->nullable();
            $table->string('emergency_number')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('tenants');
    }
}
