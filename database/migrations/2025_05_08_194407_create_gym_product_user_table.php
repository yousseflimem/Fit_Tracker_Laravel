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
        Schema::create('gym_product_user', function (Blueprint $table) {
            // User relationship (references users.userid)
            $table->foreignId('userid')->constrained('users')->onDelete('cascade');
            
            // Product relationship (references gym_products.productId)
            $table->foreignId('productId')->constrained('gym_products')->onDelete('cascade');
            
            $table->id();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_product_user');
    }
};
