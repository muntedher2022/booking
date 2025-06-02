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
        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('page_name')->comment('اسم النافذة'); // اسم النافذة
            $table->string('operation_type')->comment('نوع العملية'); // نوع العملية
            $table->timestamp('operation_time')->comment('وقت العملية'); // وقت العملية
            $table->text('details')->comment('تفاصيل العملية'); // تفاصيل العملية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking');
    }
};
