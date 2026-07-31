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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('school_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nis')->nullable();
            $table->enum('role', ['customer', 'seller', 'courier', 'system_manager'])->default('customer');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->enum('verification_status', ['unverified', 'pending_review', 'verified', 'rejected', 'suspended'])->default('unverified');
            $table->enum('courier_status', ['not_courier', 'courier_pending', 'courier_verified', 'courier_rejected', 'courier_suspended'])->default('not_courier');
            $table->string('face_photo')->nullable();
            $table->string('student_id_photo')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('courier_available')->default(false);
            
            $table->index(['school_id', 'nis']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn([
                'school_id',
                'nis',
                'role',
                'status',
                'verification_status',
                'courier_status',
                'face_photo',
                'student_id_photo',
                'phone',
                'courier_available'
            ]);
        });
    }
};
