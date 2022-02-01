<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentCreatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_creates', function (Blueprint $table) {
            $table->id();
            $table->string('document_code');
            $table->string('document_title');
            $table->text('document_detail'); 
            $table->char('document_type'); 
            $table->char('document_status'); 
            $table->integer('sender_id'); 
            $table->dateTime('expiration_date');

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
        Schema::dropIfExists('document_creates');
    }
}
