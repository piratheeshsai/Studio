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
        Schema::create('gallery_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shoot_id')->constrained()->onDelete('cascade');
            $table->string('link_token')->unique(); // secure random string for URL
            $table->timestamp('expires_at')->nullable(); // optional: auto-expire
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_links');
    }
};
