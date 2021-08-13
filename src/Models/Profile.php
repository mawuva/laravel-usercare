<?php

namespace Mawuekom\Usercare\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mawuekom\ModelUuid\Utils\GeneratesUuid;

class Profile extends Model
{
    use HasFactory, SoftDeletes, GeneratesUuid;

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        /**
         * The table associated with the model.
         *
         * @var string
         */
        $this ->table = config('usercare.user_profile.table.name');

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        $this ->primaryKey = config('usercare.user_profile.table.primary_key');
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
        'location',
        'bio',
        'description',
        'user_id',
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
        'location'                  => 'string',
        'bio'                       => 'string',
        'description'               => 'string',
        'user_id'                   => 'integer',
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
     * Scope query to check if user id exists in database.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $user_id
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCheckUserProfile($query, int $user_id): Builder
    {
        $profiles_table_user_fk = config('usercare.user_profile.table.user_foreign_key');
        return $query ->where($profiles_table_user_fk, $user_id);
    }

    /**
     * User to which profile belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        $user_model = config('usercare.user.model');
        $profiles_table_user_fk = config('usercare.user_profile.table.user_foreign_key');
        $users_table_pk = config('usercare.user.table.primary_key');

        return $this ->belongsTo($user_model, $profiles_table_user_fk, $users_table_pk);
    }
}
