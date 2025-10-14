<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_submodule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('submodule_id')->constrained('submodules')->onDelete('cascade');
            $table->timestamp('granted_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'submodule_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_submodule');
    }
};