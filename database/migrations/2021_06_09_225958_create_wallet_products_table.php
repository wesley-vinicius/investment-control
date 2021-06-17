<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->integer('product_id');
            $table->integer('quantity')->default(0);
            $table->decimal('amount_applied')->default(0);
            $table->date('start_date');
            $table->foreign('wallet_id')->references('id')
            ->on('wallets')->cascadeOnDelete();
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
        Schema::dropIfExists('wallet_products');
    }
}
