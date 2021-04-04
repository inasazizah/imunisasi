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
            $table->text('deskripsi')->nullable();
            $table->text('cara_pemberian_dosis')->nullable();
            $table->text('indikasi')->nullable();
            $table->text('indikasi_kontra')->nullable();
            $table->text('efek_samping')->nullable();
            $table->text('penanganan_efek_samping')->nullable();
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
