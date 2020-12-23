<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendTypeToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {

           $table->string('send_type')->nullable();
           $table->string('item_name')->nullable();
           $table->integer('item_qty')->default(1);

           $table->unsignedBigInteger('client_id')->nullable();
           $table->unsignedBigInteger('schedule_id')->nullable();

           $table->foreign('client_id')
                    ->references('id')->on('clients')
                    ->onDelete('cascade');

           $table->foreign('schedule_id')
                    ->references('id')->on('schedules')
                    ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
