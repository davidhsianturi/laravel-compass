<?php

namespace Davidhsianturi\Compass\Storage;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\Contracts\DocsRepository;

class DatabaseDocsRepository implements DocsRepository
{
    /**
     * Update or create route documentation.
     *
     * @param  array  $doc
     * @return \Davidhsianturi\Compass\Storage\RouteModel
     */
    public function save(array $doc)
    {
        $docId = $doc['uuid'] ?? Str::uuid();

        return RouteModel::updateOrCreate(
            ['uuid' => $docId, 'route_hash' => $doc['route_hash']],
            [
                'title' => $doc['title'],
                'description' => $doc['description'],
                'content' => $doc['content'],
                'docs' => true,
            ]
        );
    }

    /**
     * Find the route documentation by given UUID.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Database\Eloquent\ModelNotFoundException|\Davidhsianturi\Compass\Storage\RouteModel
     */
    public function find($uuid)
    {
        return RouteModel::whereDocs(true)->whereUuid($uuid)->firstOrFail();
    }

    /**
     * Delete the route documentation by given UUID.
     *
     * @param  mixed  $uuid
     * @return bool
     */
    public function delete($uuid)
    {
        return RouteModel::whereDocs(true)->whereUuid($uuid)->delete();
    }
}
