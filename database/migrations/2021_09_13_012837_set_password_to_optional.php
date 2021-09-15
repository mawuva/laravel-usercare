<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetPasswordToOptional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table =config('usercare.user.table.name');
        $password_is_optional = config('usercare.enable.optional.password');

        if ($password_is_optional) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('password')->nullable()->change();
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
        //
    }
}
