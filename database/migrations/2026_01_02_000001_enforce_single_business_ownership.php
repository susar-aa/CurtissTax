<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('business_memberships', 'owner_user_id')) {
            DB::statement("ALTER TABLE business_memberships ADD COLUMN owner_user_id BIGINT(20) UNSIGNED GENERATED ALWAYS AS (CASE WHEN is_owner = 1 THEN user_id ELSE NULL END) VIRTUAL, ADD UNIQUE KEY unique_owner_user_id (owner_user_id)");
        }
    }

    public function down()
    {
        if (Schema::hasColumn('business_memberships', 'owner_user_id')) {
            Schema::table('business_memberships', function (Blueprint $table) {
                $table->dropUnique('unique_owner_user_id');
                $table->dropColumn('owner_user_id');
            });
        }
    }
};
