<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_product_id');
            $table->tinyInteger('type');
            $table->decimal('price');
            $table->decimal('amount');
            $table->integer('quantity');
            $table->date('date');
            $table->decimal('rates')->default(0);
            $table->foreign('wallet_product_id')->references('id')
            ->on('wallet_products')->cascadeOnDelete();
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
        Schema::dropIfExists('movements');
    }
}
