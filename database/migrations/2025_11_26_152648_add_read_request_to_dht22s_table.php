<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dht22s', function (Blueprint $table) {
            $table->boolean('read_request')->default(false)->after('min_humidity');
        });
    }

    public function down(): void
    {
        Schema::table('dht22s', function (Blueprint $table) {
            $table->dropColumn('read_request');
        });
    }
};