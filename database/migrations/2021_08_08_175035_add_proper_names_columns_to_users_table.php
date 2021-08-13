<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProperNamesColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = config('usercare.user.table.name');
        $proper_names_enabled = config('usercare.proper_names.enable');

        if ($proper_names_enabled) {
            Schema::table($table, function (Blueprint $table) {
                if (!schema_has_proper_names_columns()) {
                    $table->string('last_name') ->nullable() ->after('name');
                    $table->string('first_name') ->nullable() ->after('last_name');
                }
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
        $table =config('usercare.user.table.name');

        Schema::table($table, function (Blueprint $table) {
            if (schema_has_proper_names_columns()) {
                $table ->dropColumn('last_name');
                $table ->dropColumn('first_name');
            }
        });
    }
}
