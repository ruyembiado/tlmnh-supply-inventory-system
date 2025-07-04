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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category')->nullable();
            $table->string('stock_no')->nullable();
            $table->integer('restock_point')->nullable();
            $table->decimal('unit_cost', 10, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->string('unit'); 
            $table->text('description')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
