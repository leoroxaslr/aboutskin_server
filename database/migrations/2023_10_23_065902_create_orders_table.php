<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("order_id");
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("product_id")->index();
            $table->integer("quantity");
            $table->decimal("total")->default(0);
            $table->decimal("total_price")->default(0);
            $table->enum("status", ["Pending", "For Packaging", "Out for Delivery", "Cancelled"]);
            $table->enum("payment_type", ["Debit/Credit Card", "Cash on Delivery"]);
            $table->timestamps();
            $table->string('address')->nullable();
            $table->decimal('weight')->nullable();
$table->decimal('length')->nullable();
$table->decimal('width')->nullable();
$table->decimal('height')->nullable();
$table->string('item_type')->nullable();
$table->string('phone_number')->nullable();
$table->string('postal_code')->nullable();
$table->string('customer_name')->nullable();
$table->string('customer_order_number')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
