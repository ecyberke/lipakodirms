<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constrained();
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'half_yearly', 'annual']);
            $table->decimal('amount', 10, 2);
            $table->integer('units');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->date('grace_ends_at')->nullable();
            $table->enum('status', ['active', 'grace', 'suspended', 'cancelled'])->default('active');
            $table->string('payment_method')->nullable(); // mpesa, bank, paybill
            $table->string('payment_reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('subscriptions');
    }
};
