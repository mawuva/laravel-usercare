<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUuidColumnsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table                      = config('usercare.user.table.name');
        $users_table_primary_key    = config('usercare.user.table.primary_key');

        $uuid_enable                = config('usercare.uuids.enable');
        $uuid_column                = config('usercare.uuids.column');

        if ($uuid_enable && $uuid_column !== null) {
            Schema::table($table, function (Blueprint $table) 
            use($uuid_column, $users_table_primary_key) {
                $table->uuid($uuid_column) ->after($users_table_primary_key);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table          = config('usercare.user.table.name');
        $uuid_column    = config('usercare.uuids.column');

        Schema::table($table, function (Blueprint $table) use($uuid_column) {
            $table->dropColumn($uuid_column);
        });
    }
}
