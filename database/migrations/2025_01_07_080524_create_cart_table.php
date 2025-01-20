<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User reference
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Product reference
            $table->integer('quantity')->default(1); // Quantity of the product
            $table->string('color')->nullable(); // Selected color
            $table->string('size')->nullable(); // Selected size
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart');
    }
}
