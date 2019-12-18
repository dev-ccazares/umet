<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_period')->unsigned();
            $table->integer('codigo_ies');
            $table->string('codigo_carrera')->nullable();
            $table->string('ci_estudiante');
            $table->string('nombre_estudiante');
            $table->string('nombre_institucion');
            $table->string('tipo_institucion');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->integer('numero_horas')->default(0);
            $table->string('campo_especifico')->nullable();
            $table->string('docente_tutor')->nullable();
            $table->boolean('convalidacion')->default(0);
            $table->timestamps();

            $table->foreign('id_period')->references('id')->on('period')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registry');
    }
}
