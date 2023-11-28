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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('end_point')->nullable();
            $table->json('source')->nullable();
            $table->text('author')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('type')->nullable();
            $table->text('url')->nullable();
            $table->json('images')->nullable();
            $table->string('published_at')->nullable();
            $table->longText('category')->nullable();
            $table->text('content')->nullable();
            // $table->string('section_id')->nullable();
            // $table->string('settings')->nullable();
            // $table->text('api_url')->nullable();
            // $table->string('pillar_id')->nullable();
            // $table->string('pillar_name')->nullable();
            // $table->string('section')->nullable();
            // $table->string('sub_section')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
