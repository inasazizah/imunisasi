<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImunisasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imunisasis', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('deskripsi')->nullable();
            $table->string('cara_pemberian_dosis')->nullable();
            $table->string('indikasi')->nullable();
            $table->string('indikasi_kontra')->nullable();
            $table->string('efek_samping')->nullable();
            $table->string('penanganan_efek_samping')->nullable();
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
        Schema::dropIfExists('imunisasis');
    }
}
