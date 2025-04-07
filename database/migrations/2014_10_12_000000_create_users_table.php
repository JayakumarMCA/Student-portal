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
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->string('mobile')->unique();
            // $table->string('password');
            // $table->string('organization');
            // $table->string('job_title');
            // $table->string('city');
            // $table->string('country_id');
            // $table->string('role_id');
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->enum('whatsapp_num', ['1', '2'])->comment('1 = Yes, 2 = No');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->enum('graduate', ['1', '2'])->comment('1 = UG, 2 = PG');
            $table->string('photo_copy')->nullable();
            $table->string('doc')->nullable();
            $table->string('year_of_passing')->nullable();
            $table->string('id_proof_photo_copy')->nullable();
            $table->string('nri')->nullable()->comment('1 = Yes, 2 = No');
            $table->string('passport_photo_copy')->nullable();
            $table->enum('status', ['1', '2', '3', '4'])->default('1')->comment('1 = Pending, 2 = Approval, 3 = Course Completed, 4 = Test Completed');
            $table->enum('user_type', ['1', '2'])->default('1')->comment('1 = User, 2 = Student');
            $table->string('password');
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
