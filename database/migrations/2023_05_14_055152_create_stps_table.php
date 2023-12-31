<?php

use Symfony\Component\Uid\Ulid;
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
        Schema::create('stps', function (Blueprint $table) {
            $table->ulid('id')->primary()->default(Ulid::generate());
            $table->string('user_id', 26);
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_backdate');
            $table->date('tanggal')->nullable();
            $table->string('unit_kerja');
            $table->foreignId('pp_id');
            $table->string('nama_pp');
            $table->text('melaksanakan');
            $table->date('mulai');
            $table->date('selesai');
            $table->foreignId('pembebanan_id');
            $table->text('pegawai');
            $table->string('penandatangan', 26)->nullable();
            $table->foreign('penandatangan')->references('id_pimpinan')->on('master_pimpinans')->onDelete('cascade');
            $table->smallInteger('status');
            $table->string('no_surat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->boolean('is_esign');
            $table->text('draft')->nullable();
            $table->text('file')->nullable();
            $table->text('sertifikat')->nullable();
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('stps');
    }
};
