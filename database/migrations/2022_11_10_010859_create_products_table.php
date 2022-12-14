<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 20)->nullable(false);
            $table->string('nama_barang', 50)->nullable(false);
            $table->integer('stok_barang')->nullable(false)->default(0);
            $table->string('status_barang', 15)->nullable(false);
            $table->string('gambar_barang', 200)->nullable(false);
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
        Schema::dropIfExists('products');
    }
};
