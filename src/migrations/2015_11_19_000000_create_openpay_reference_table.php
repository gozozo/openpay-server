<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpenpayReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openpay_reference', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();;
            $table->string('openpay_id');
            $table->timestamps();

            if(getenv('OPENPAY_REFERENCE') !=='' && getenv('OPENPAY_TABLE')){
                $table->foreign("user_id")->references(getenv('OPENPAY_REFERENCE'))->on(getenv('OPENPAY_TABLE'));
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('openpay_reference');
    }
}