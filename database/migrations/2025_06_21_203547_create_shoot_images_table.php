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
        Schema::create('shoot_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shoot_id')->constrained()->onDelete('cascade');
            $table->foreignId('shoot_subcategory_id')->nullable()->constrained()->onDelete('set null');
            $table->string('filename'); // stored filename
            $table->string('original_name')->nullable(); // original file name
            $table->string('file_type'); // jpg, raw, etc.
            $table->integer('file_size')->nullable(); // in KB or bytes
            $table->string('storage_path'); // path in cloud/local storage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoot_images');
    }
};
