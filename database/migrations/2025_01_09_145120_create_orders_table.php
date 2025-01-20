<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Linking to the users table
            $table->foreignId('shipping_address_id')->constrained('addresses')->onDelete('cascade'); // User's selected shipping address
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Linking to orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Linking to products
            $table->integer('quantity'); // Quantity of the product
            $table->decimal('price', 10, 2); // Price of the product at the time of order
            $table->decimal('total', 10, 2); // Total cost for the quantity of this product
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}
