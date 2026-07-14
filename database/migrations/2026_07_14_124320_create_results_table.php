<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->cascadeOnDelete();
            $table->foreignId('driver_id')->constrained();
            $table->foreignId('constructor_id')->constrained();
            $table->unsignedTinyInteger('grid')->nullable();
            $table->unsignedTinyInteger('position')->nullable();
            $table->decimal('points', 5, 1)->default(0);
            $table->string('status')->nullable();
            $table->string('fastest_lap_time')->nullable();
            $table->timestamps();

            $table->unique(['race_id', 'driver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
