<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            if (! Schema::hasColumn('menus', 'stock')) {
                $table->unsignedInteger('stock')->default(0)->after('is_available');
            }
            $table->text('description')->nullable()->change();
            $table->string('img_url')->nullable()->change();
            $table->boolean('is_available')->default(true)->change();
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            if (Schema::hasColumn('menus', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }
};
