<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateOpenpayPayorderReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('openpay_payorder_reference', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('openpay_id',50);
            $table->timestamps();

            if(env('OPENPAY_REFERENCE') !=='' && env('OPENPAY_TABLE') !== ''){
                $table->foreign("user_id")->references(env('OPENPAY_REFERENCE'))->on(env('OPENPAY_TABLE'));
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
        if(env('OPENPAY_REFERENCE') !=='' && env('OPENPAY_TABLE') !== ''){
            Schema::table('openpay_payorder_reference', function (Blueprint $table) {
                $table->dropForeign('openpay_payorder_reference_user_id_foreign');
            });
        }
        Schema::dropIfExists('openpay_payorder_reference');
    }
}