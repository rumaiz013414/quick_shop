<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tshirt_id')->constrained()->onDelete('cascade'); // T-shirt being sold
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity'); // Number of units sold
            $table->decimal('total_price', 8, 2); // Total price of the sale
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
