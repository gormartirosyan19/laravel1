<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Foreign key to orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Foreign key to products
            $table->integer('quantity'); // Quantity of the product in the order
            $table->decimal('price', 10, 2); // Price of the product at the time of order
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
