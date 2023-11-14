<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('spatial_features', function (Blueprint $table) {
            $table->string('description_source')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('spatial_features', function (Blueprint $table) {
            $table->dropColumn('description_source');
        });
    }
};
