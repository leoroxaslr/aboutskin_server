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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("brand");
            $table->text("description")->nullable();
            $table->text("description_long")->nullable();
            $table->decimal("price");
            $table->decimal("stock")->nullable();
            $table->integer('rating')->default(5)->nullable();
            $table->unsignedBigInteger("category_id")->index();
            $table->string('image')->default('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
