<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $profile_enabled                    = config('usercare.user_profile.enable');

        $table                              = config('usercare.user_profile.table.name');
        $profiles_table_primary_key         = config('usercare.user_profile.table.primary_key');
        $profiles_table_user_foreign_key    = config('usercare.user_profile.table.user_foreign_key');

        $users_table                        = config('usercare.user.table.name');
        $users_table_primary_key            = config('usercare.user.table.primary_key');

        $uuid_enable                        = config('usercare.uuids.enable');
        $uuid_column                        = config('usercare.uuids.column');

        if ($profile_enabled) {
            Schema::create($table, function (Blueprint $table) 
            use (
                $profiles_table_primary_key, $uuid_enable, $uuid_column, 
                $profiles_table_user_foreign_key, $users_table_primary_key, $users_table
            ) {
                $table->id($profiles_table_primary_key) ->unsigned();

                if ($uuid_enable && $uuid_column !== null) {
                    $table->uuid($uuid_column);
                }

                $table->string('location');
                $table->text('bio')->nullable();
                $table->text('description')->nullable();
                $table->unsignedBigInteger($profiles_table_user_foreign_key)->unsigned()->index();
                $table->foreign($profiles_table_user_foreign_key)->references($users_table_primary_key)->on($users_table)->onDelete('cascade');
                $table->timestamps();
                $table->softDeletes();
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
        $table = config('usercare.user_profile.table.name');

        Schema::dropIfExists($table);
    }
}
