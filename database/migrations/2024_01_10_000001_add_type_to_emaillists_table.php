<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('emaillists', function (Blueprint $table) {
            if (!Schema::hasColumn('emaillists', 'type')) {
                $table->enum('type', ['section', 'department'])->default('section')->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('emaillists', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
