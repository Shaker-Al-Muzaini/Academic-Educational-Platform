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
        Schema::create('parent_students', function (Blueprint $table) {
            $table->id();
            $table->string('email_mother');
            $table->string('password_mother');
            $table->string('password_Father');
            $table->string('email_Father');
            $table->string('Name_Father');
            $table->string('National_ID_Father');
            $table->string('Phone_Father');
            $table->string('Job_Father');
            $table->bigInteger('Nationality_Father_id')->unsigned();
            $table->string('Address_Father');
            $table->string('Name_Mother');
            $table->string('National_ID_Mother');
            $table->string('Phone_Mother');
            $table->string('Job_Mother');
            $table->bigInteger('Nationality_Mother_id')->unsigned();
            $table->string('Address_Mother');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_students');
    }
};
