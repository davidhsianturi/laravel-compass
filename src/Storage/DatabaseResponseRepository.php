<?php

namespace Davidhsianturi\Compass\Storage;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\Contracts\ResponseRepository;

class DatabaseResponseRepository implements ResponseRepository
{
    /**
     * Update or create route response.
     *
     * @param  array  $response
     * @return \Davidhsianturi\Compass\Storage\RouteModel
     */
    public function save(array $response)
    {
        $responseId = $response['uuid'] ?? Str::uuid();

        return RouteModel::updateOrCreate(
            ['uuid' => $responseId, 'route_hash' => $response['route_hash']],
            [
                'title' => $response['title'],
                'description' => $response['description'],
                'content' => $response['content'],
                'example' => true,
            ]
        );
    }

    /**
     * Find the route response by given UUID.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Database\Eloquent\ModelNotFoundException|\Davidhsianturi\Compass\Storage\RouteModel
     */
    public function find($uuid)
    {
        return RouteModel::whereExample(true)->whereUuid($uuid)->firstOrFail();
    }

    /**
     * Delete the route response by given UUID.
     *
     * @param  mixed  $uuid
     * @return bool
     */
    public function delete($uuid)
    {
        return RouteModel::whereExample(true)->whereUuid($uuid)->delete();
    }
}
