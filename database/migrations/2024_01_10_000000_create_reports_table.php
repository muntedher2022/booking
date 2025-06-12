<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('العنوان');
            $table->string('source')->comment('مصدر التقرير');
            $table->json('filters')->nullable()->comment('فلاتر التقرير');
            $table->json('columns')->nullable()->comment('اعمدة التقرير');
            $table->unsignedBigInteger('created_by')->comment('منشئ التقرير');
            $table->string('status')->default('active')->comment('الحالة');
            $table->timestamps();

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
