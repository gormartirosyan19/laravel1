<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToPasswordsResets extends Migration
{
    public function up(): void
    {
        Schema::table('passwords_resets', function (Blueprint $table) {
            $table->string('email')->nullable()->after('user_id');
            // Nullable column so existing users are not affected
        });
    }

    public function down(): void
    {
        Schema::table('passwords_resets', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
