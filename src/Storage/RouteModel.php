<?php

namespace Davidhs\Compass\Storage;

use Illuminate\Database\Eloquent\Model;

class RouteModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'compass_routeables';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'storage_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'network' => 'array',
    ];

    /**
     * Get the current connection name for the model.
     *
     * @return string
     */
    public function getConnectionName()
    {
        return config('compass.storage.database.connection');
    }
}
