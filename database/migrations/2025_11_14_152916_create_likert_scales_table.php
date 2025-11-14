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
        Schema::create('likert_scales', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_value');
            $table->integer('max_value');
            $table->string('min_label', 100);
            $table->string('max_label', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likert_scales');
    }
};
