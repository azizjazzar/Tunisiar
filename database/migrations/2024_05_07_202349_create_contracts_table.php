<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('clientType');
            $table->string('list');
            $table->string('libelle');
            $table->date('contractStartDate');
            $table->date('contractEndDate');
            $table->integer('minimumGuaranteed');
            $table->date('travelStartDate');
            $table->date('travelEndDate');
            $table->boolean('isActive')->default(true);
            $table->boolean('activateInternetFees')->default(true);
            $table->float('modifyFeesAmount')->nullable();
            $table->boolean('TKXL')->default(false);
            $table->boolean('payLater')->default(false);
            $table->integer('payLaterTimeLimit')->nullable();
            $table->integer('minTimeBeforeFlightCC')->nullable();
            $table->integer('minTimeBeforeFlightBalance')->nullable();
            $table->boolean('stampInvoice')->default(false);
            $table->float('additionalClientFees')->nullable();
            $table->float('discount')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
