<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendaProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_produtos', function (Blueprint $table) {
            $table->bigInteger("produtos_id")->unsigned();
            $table->foreign("produtos_id")->references("id")->on("produtos")->onDelete("cascade");
            $table->bigInteger("vendas_id")->unsigned();
            $table->foreign("vendas_id")->references("id")->on("vendas")->onDelete("cascade");
            $table->primary(["vendas_id", "produtos_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda_produtos');
    }
}
