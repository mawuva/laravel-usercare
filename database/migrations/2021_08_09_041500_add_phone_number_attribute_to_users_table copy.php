<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPhoneNumberAttributeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table =config('usercare.user.table.name');
        $phone_number_enabled = config('usercare.enable.phone_number');

        if ($phone_number_enabled) {
            Schema::table($table, function (Blueprint $table) {
                if (!schema_has_phone_number_column()) {
                    $table->string('phone_number') ->nullable() ->after('email');
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
        $table = config('usercare.user.table.name');

        Schema::table($table, function (Blueprint $table) {
            if (schema_has_phone_number_column()) {
                $table ->dropColumn('phone_number');
            }
        });
    }
}
