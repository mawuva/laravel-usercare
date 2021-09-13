<?php

namespace Mawuekom\Usercare\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mawuekom\ModelUuid\Utils\GeneratesUuid;
use Mawuekom\Usercare\Traits\Slugable;

class AccountType extends Model
{
    use HasFactory, SoftDeletes, GeneratesUuid, Slugable;

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * 
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        /**
         * The table associated with the model.
         *
         * @var string
         */
        $this ->table = config('usercare.account_type.table.name');

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        $this ->primaryKey = config('usercare.account_type.table.primary_key');
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                        => 'integer',
        'name'                      => 'string',
        'slug'                      => 'string',
        'description'               => 'string',
        'created_at'                => 'datetime',
        'updated_at'                => 'datetime',
        'deleted_at'                => 'datetime',
    ];

    /**
     * The names of the columns that should be used for the UUID.
     *
     * @return array
     */
    public function uuidColumns(): array
    {
        return [config('usercare.uuids.column')];
    }

    /**
     * User has profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        $user_model = config('usercare.user.model');
        $users_table_account_type_fk = config('usercare.user.table.account_type_foreign_key');
        $account_types_table_pk = config('usercare.account_type.table.primary_key');

        return $this ->hasMany($user_model, $users_table_account_type_fk, $account_types_table_pk);
    }

    /**
     * Get account type's users count
     *
     * @return int
     */
    public function getUsersCountAttribute(): int
    {
        return $this ->users() ->count();
    }
}