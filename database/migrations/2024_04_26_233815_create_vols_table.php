<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vols', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('leaving_from');
            $table->foreign('leaving_from')->references('id')->on('destinations')->onDelete('cascade');

            $table->unsignedBigInteger('going_to');
            $table->foreign('going_to')->references('id')->on('destinations')->onDelete('cascade');

            $table->dateTime('departure');
            $table->dateTime('access');
            $table->boolean('stopover')->default(false);

            $table->bigInteger('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vols');
    }
};
