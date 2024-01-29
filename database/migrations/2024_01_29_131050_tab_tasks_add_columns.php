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
            $table->uuidMorphs('element');
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('team_id');
            $table->unsignedBigInteger('color_id')->default(0);
            $table->date('day')->useCurrent();
            $table->time('start')->useCurrent();
            $table->time('end')->useCurrent();
            $table->text('content')->nullable();
    });
    }
};
