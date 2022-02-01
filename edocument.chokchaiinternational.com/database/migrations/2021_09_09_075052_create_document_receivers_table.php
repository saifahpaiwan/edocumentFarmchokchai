<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_receivers', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id'); 
            $table->integer('users_id'); 
            $table->char('signing_rights'); 
            $table->char('passwrod_is'); 
            $table->string('passwrod');  
            $table->text('signing_position');
            $table->integer('area_size');

            $table->char('status_approve');   
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_receivers');
    }
}
