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
        Schema::create('likert_scale_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('likert_scale_id')->constrained('likert_scales')->cascadeOnDelete();
            $table->integer('value');
            $table->string('label', 100);
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likert_scale_options');
    }
};
