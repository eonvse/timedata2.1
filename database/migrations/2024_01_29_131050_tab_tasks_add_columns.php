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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('team_id')->default(0);
            $table->unsignedBigInteger('color_id')->default(0);
            $table->date('day')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
            $table->text('content')->nullable();
            $table->boolean('isDone')->default(0);
            $table->dateTime('dateDone')->nullable();
    });
    }
};
