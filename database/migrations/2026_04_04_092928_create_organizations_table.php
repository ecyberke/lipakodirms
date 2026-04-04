<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique(); // subdomain slug e.g. "demo"
            $table->enum('type', ['agency', 'individual'])->default('agency');
            $table->string('contact_person')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('kra_pin')->nullable();
            $table->string('county')->nullable();
            $table->string('town')->nullable();
            $table->string('currency', 10)->default('KES');
            $table->integer('total_units')->default(0);
            $table->string('tenant_account_prefix')->default('LKT');
            $table->string('landlord_account_prefix')->default('LKL');
            $table->string('property_account_prefix')->default('LKP');
            $table->string('sms_username')->nullable();
            $table->string('sms_password')->nullable();
            $table->string('mpesa_consumer_key')->nullable();
            $table->string('mpesa_consumer_secret')->nullable();
            $table->string('mpesa_shortcode')->nullable();
            $table->string('mpesa_passkey')->nullable();
            $table->string('mpesa_paybill')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('whatsapp_token')->nullable();
            $table->string('whatsapp_phone_id')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_from_email')->nullable();
            $table->string('smtp_from_name')->nullable();
            $table->boolean('mfa_enabled')->default(false);
            $table->boolean('whatsapp_enabled')->default(false);
            $table->boolean('email_enabled')->default(false);
            $table->enum('status', ['pending', 'active', 'suspended', 'cancelled'])->default('pending');
            $table->boolean('currency_set')->default(false);
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('organizations');
    }
};
