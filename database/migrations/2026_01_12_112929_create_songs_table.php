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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('album_id')
                ->constrained('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('album_name');

            $table->foreignId('artist_id')
                ->constrained('artists')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('artist_name');

            $table->string('name');
            $table->string('year');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
