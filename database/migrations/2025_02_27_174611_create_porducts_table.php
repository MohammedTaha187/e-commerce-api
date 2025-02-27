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
            $table->string('name' , 100);
              $table->text('desc')->nullable();
              $table->string('image')->nullable();
              $table->decimal('price', 10, 2);
              $table->decimal('discounted_price', 10, 2)->nullable();
              $table->integer('quantity');
              $table->boolean('status')->default(1);
              $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porducts');
    }
};
