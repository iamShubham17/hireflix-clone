<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('created_by')->constrained('users');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
};