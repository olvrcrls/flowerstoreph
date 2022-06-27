<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            // $table->foreignId('user_id')->constrained(); // Since there is no statement about the requirement that the foreign key needs to be constrained
            $table->unsignedBigInteger('product_id')->index();
            // $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Since there is no statement about the requirement that the foreign key needs to be constrained
            // Added a correction to table design given from the test: add attribute quantity
            $table->unsignedInteger('quantity');

            $table->unsignedInteger('price'); // We will use integer since it uses less memory on the database than double, decimal, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
