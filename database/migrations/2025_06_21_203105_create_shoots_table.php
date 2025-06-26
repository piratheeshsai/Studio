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
        Schema::create('shoots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constraind()->onDelete('cascade');
            $table->string('title')->nullable(); // Optional title for the shoot
            $table->string('type'); // e.g., Wedding, Birthday
            $table->date('shoot_date');
            $table->foreignId('shoot_package_id')->nullable()->constrained('shoot_packages')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoots');
    }
};
