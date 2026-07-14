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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('ref')->unique(); // driverId da Jolpica, ex: "hamilton"
            $table->string('code', 3)->nullable(); // HAM, VER...
            $table->unsignedSmallInteger('number')->nullable();
            $table->string('forename');
            $table->string('surname');
            $table->string('nationality')->nullable();
            $table->date('dob')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
