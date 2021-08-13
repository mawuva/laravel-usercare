<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table =config('usercare.user.table.name');

        Schema::table($table, function (Blueprint $table) {
            if (!schema_has_gender_column()) {
                $table->string('gender') ->nullable() ->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('usercare.user.table.name');

        Schema::table($table, function (Blueprint $table) {
            if (schema_has_gender_column()) {
                $table ->dropColumn('phone_number');
            }
        });
    }
}
