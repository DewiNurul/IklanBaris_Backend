<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Barang extends Migration
{
  
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul');
            $table->enum('kategori', array('pakaian','mobil','sepeda motor'))->default('pakaian');
            $table->string('harga');
            $table->string('lokasi');
            $table->string('deskripsi');
            $table->string('gambar');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
