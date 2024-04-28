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
        Schema::create('slugs', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->string('slug')->unique();
            $table->string('seo_title')->nullable();
            $table->longText('seo_description')->nullable();
            $table->tinyInteger('no_index')->default(0);
            $table->tinyInteger('no_follow')->default(0);
            $table->string('language')->default('tr');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slugs');
    }
};
