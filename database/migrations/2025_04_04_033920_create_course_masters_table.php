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
        Schema::create('course_masters', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1 = UG, 2 = PG');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('duration'); // e.g., "3 Years"
            $table->boolean('status')->default(1)->comment('1 = active, 2 = inactive'); // 1 = active, 0 = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_masters');
    }
};
