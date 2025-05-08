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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();  // Matches UML's reviewId: int
            
            // Fixed user relationship (matches users.userid)
            $table->foreignId('userid')->constrained('users') ->onDelete('cascade');
            
            // Fixed product relationship (matches gym_products.productId)
            $table->foreignId('productId')->constrained('gym_products')  ->onDelete('cascade');
            
            $table->integer('rating');
            $table->text('comment');
            $table->dateTime('createdAt');  
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
