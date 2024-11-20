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
        Schema::create('gift_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->delete('cascade');
            $table->foreignId('gift_id')->constrained('gifts')->delete('cascade');
            $table->string('member_code')->constrained('members')->delete('cascade');
            $table->integer("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_results');
    }

};
