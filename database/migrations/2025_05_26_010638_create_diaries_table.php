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
       Schema::create('diaries', function (Blueprint $table) {
        $table->id();
        $table->string('username'); 
        $table->string('title');
        $table->text('content');
        $table->string('mood');
        $table->date('diary_date');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaries');
    }
};
