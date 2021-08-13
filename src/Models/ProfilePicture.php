<?php

namespace Mawuekom\Usercare\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mawuekom\ModelUuid\Utils\GeneratesUuid;

class ProfilePicture extends Model
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
        $this ->table = config('usercare.user_profile_picture_picture.table.name');

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        $this ->primaryKey = config('usercare.user_profile_picture_picture.table.primary_key');
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
        'avatar_title',
        'avatar_mime',
        'avatar_url',
        'avatar_status',
        'bg_picture_title',
        'bg_picture_mime',
        'bg_picture_url',
        'bg_picture_status',
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
        'avatar_title'              => 'string',
        'avatar_mime'               => 'string',
        'avatar_url'                => 'string',
        'bg_picture_title'          => 'string',
        'bg_picture_mime'           => 'string',
        'bg_picture_url'            => 'string',
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
    public function scopeCheckUserProfilePicture($query, int $user_id): Builder
    {
        $profile_pictures_table_user_fk = config('usercare.user_profile_picture.table.user_foreign_key');
        return $query ->where($profile_pictures_table_user_fk, $user_id);
    }

    /**
     * User to which profile belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        $user_model = config('usercare.user.model');
        $profile_pictures_table_user_fk = config('usercare.user_profile_picture.table.user_foreign_key');
        $users_table_pk = config('usercare.user.table.primary_key');

        return $this ->belongsTo($user_model, $profile_pictures_table_user_fk, $users_table_pk);
    }

    /**
     * Resolve avatar url
     *
     * @return string
     */
    public function getAvatarUrlAttribute(): string
    {
        $default_file_url = config('usercare.user_profile_picture.default.file_source_url');
        $default_avatar_url = config('usercare.user_profile_picture.default.avatar');

        if ($this->attributes['avatar_url']) {
            if (preg_match('/^https?:\/\//', $this->attributes['avatar_url'])) {
                return sprintf('%s', $this->attributes['avatar_url']);
            }

            return sprintf('%s%s', $default_file_url, $this->attributes['avatar_url']);
        }

        else {
            return $default_avatar_url;
        }
    }

    /**
     * Resolve bg picture url
     *
     * @return string
     */
    public function getBgPictureUrlAttribute(): string
    {
        $default_file_url = config('usercare.user_profile_picture.default.file_source_url');
        $default_bg_picture_url = config('usercare.user_profile_picture.default.bg_picture');

        if ($this->attributes['bg_picture_url']) {
            if (preg_match('/^https?:\/\//', $this->attributes['bg_picture_url'])) {
                return sprintf('%s', $this->attributes['bg_picture_url']);
            }

            return sprintf('%s%s', $default_file_url, $this->attributes['bg_picture_url']);
        }

        else {
            return $default_bg_picture_url;
        }
    }
}
