<?php

namespace Davidhsianturi\Compass\Contracts;

interface DocsRepository
{
    /**
     * Update or create the given docs.
     *
     * @param  array  $docs
     * @return \Davidhsianturi\Compass\Storage\RouteModel
     */
    public function save(array $docs);

    /**
     * Find the route documentation by given UUID.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Database\Eloquent\ModelNotFoundException|\Davidhsianturi\Compass\Storage\RouteModel
     */
    public function find($uuid);

    /**
     * Delete the route documentation by given UUID.
     *
     * @param  mixed  $uuid
     * @return bool
     */
    public function delete($uuid);
}
