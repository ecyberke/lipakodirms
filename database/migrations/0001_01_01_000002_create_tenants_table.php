<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('account_number')->nullable();
            $table->string('full_name');
            $table->string('email');
            $table->string('username')->nullable();
            $table->string('phone_no');
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('id_number')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('occupied_at')->nullable();
            $table->string('job_contact')->nullable();
            $table->string('emergency_person')->nullable();
            $table->string('emergency_number')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->tinyInteger('status')->default(0);
            $table->string('type_select')->nullable();
            $table->string('user_id')->nullable();
            $table->string('kin_id')->nullable();
            $table->string('relationship')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
