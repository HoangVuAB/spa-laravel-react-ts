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
            $table->string('google_id')->nullable()->after('id');
            $table->renameColumn('name', 'user_name');
            $table->string('user_name_kana')->nullable()->after('name');
            $table->string('phone_number')->nullable()->after('user_name_kana');
            $table->string('postcode')->nullable()->after('phone_number');
            $table->string('address')->nullable()->after('postcode');
            $table->string('address_detail')->nullable()->after('address');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_name', 'name');
            $table->dropColumn('user_name_kana');
            $table->dropColumn('phone_number');
            $table->dropColumn('postcode');
            $table->dropColumn('address');
            $table->dropColumn('address_detail');
            $table->dropColumn('google_id');
            $table->dropColumn('deleted_at');
        });
    }
};
