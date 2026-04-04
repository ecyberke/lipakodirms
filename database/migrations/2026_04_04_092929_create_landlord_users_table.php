<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('landlord_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('org_id')->default(1);
            $table->string('account_number')->unique(); // LKL00001
            $table->string('full_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('landlord_id')->nullable(); // links to landlords table
            $table->boolean('mfa_enabled')->default(false);
            $table->string('mfa_code')->nullable();
            $table->timestamp('mfa_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->index('org_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('landlord_users');
    }
};
