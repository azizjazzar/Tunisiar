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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',100); // organization Name of client
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->enum('user_type', ['admin', 'client_b_to_b'])->default('client_b_to_b');
            
            $table->string('address',255)->nullable();
            $table->bigInteger('phoneNumber1')->nullable();
            $table->bigInteger('phoneNumber2')->nullable();
            $table->bigInteger('fax')->nullable();

            $table->boolean('state')->default(1); // activee

            $table->string('logo_path', 150)->nullable();
            $table->string('logo_name', 150)->nullable();
            $table->integer('logo_size')->nullable();

            $table->enum('client_type', ['0','1','2'])->nullable(); // 0: 'corporate', 1: 'agence_a', 2:'agence_b'
            $table->enum('currency', ['TND','EURO'])->default('TND');

            $table->string('corporate_code')->nullable();
            $table->string('mission_code')->nullable();

            $table->string('tax_identification_number')->nullable(); // code fiscale

            $table->string('owner')->nullable();
            $table->string('officeIdQueue')->nullable();

            $table->rememberToken();
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
