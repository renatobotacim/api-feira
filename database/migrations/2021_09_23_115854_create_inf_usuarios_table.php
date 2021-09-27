<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inf_usuarios', function (Blueprint $table) {
            $table->increments('usuario_id');
            $table->string('usuario_nome');
            $table->string('usuario_cpf_cnpj');
            $table->string('usuario_email');
            $table->string('usuario_senha');
            $table->string('usuario_senha');
            $table->integer('usuario_senha');
            $table->timestamp('usuario_registro') ;
            $table->unsignedDecimal('usuario_saldo',$precision = 10, $scale = 2) ;
            $table->integer('usuario_status') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inf_usuarios');
    }
}
