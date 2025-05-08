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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            
            // For userid relationship
            $table->foreignId('userid')->constrained('users')->onDelete('cascade');
            
            // For typeId relationship
            $table->foreignId('typeId')->constrained('membership_types')->onDelete('cascade');
            
            $table->date('startDate');
            $table->date('endDate');
            $table->enum('status', ['Active', 'Expired'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
