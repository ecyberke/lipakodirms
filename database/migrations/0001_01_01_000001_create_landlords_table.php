<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landlords', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('full_name');
            $table->string('other_names')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->string('id_number')->nullable();
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landlords');
    }
};
