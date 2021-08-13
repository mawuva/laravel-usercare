<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $profile_picture_enabled                    = config('usercare.user_profile_picture.enable');

        $table                                      = config('usercare.user_profile_picture.table.name');
        $profile_pictures_table_primary_key         = config('usercare.user_profile_picture.table.primary_key');
        $profile_pictures_table_user_foreign_key    = config('usercare.user_profile_picture.table.user_foreign_key');

        $users_table                        = config('usercare.user.table.name');
        $users_table_primary_key            = config('usercare.user.table.primary_key');

        $uuid_enable                        = config('usercare.uuids.enable');
        $uuid_column                        = config('usercare.uuids.column');

        if ($profile_picture_enabled) {
            Schema::create($table, function (Blueprint $table) 
            use (
                $profile_pictures_table_primary_key, $uuid_enable, $uuid_column, 
                $profile_pictures_table_user_foreign_key, $users_table_primary_key, $users_table
            ) {
                
                $table->id($profile_pictures_table_primary_key)->unsigned();

                if ($uuid_enable && $uuid_column !== null) {
                    $table->uuid($uuid_column);
                }

                $table->string('avatar_title')->nullable();
                $table->string('avatar_mime')->nullable();
                $table->string('avatar_url')->nullable();
                $table->boolean('avatar_status')->default(0);
                $table->string('bg_picture_title')->nullable();
                $table->string('bg_picture_mime')->nullable();
                $table->string('bg_picture_url')->nullable();
                $table->boolean('bg_picture_status')->default(0);
                $table->unsignedBigInteger($profile_pictures_table_user_foreign_key)->unsigned()->index();
                $table->foreign($profile_pictures_table_user_foreign_key)->references($users_table_primary_key)->on($users_table)->onDelete('cascade');
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
        $table = config('usercare.user_profile_picture.table.name');

        Schema::dropIfExists($table);
    }
}
