<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemFakturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_faktur', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->decimal('diskon', 5, 2)->nullable();
            $table->timestamps();
            $table->foreign('faktur_id')->references('id')->on('faktur')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_faktur');
    }
}
