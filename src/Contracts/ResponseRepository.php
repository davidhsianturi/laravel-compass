<?php

namespace Davidhsianturi\Compass\Contracts;

interface ResponseRepository
{
    /**
     * Update or create the given route response.
     *
     * @param  array  $response
     * @return \Davidhsianturi\Compass\Storage\RouteModel
     */
    public function save(array $response);

    /**
     * Find the route response by given UUID.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Database\Eloquent\ModelNotFoundException|\Davidhsianturi\Compass\Storage\RouteModel
     */
    public function find($uuid);

    /**
     * Delete the route response by given UUID.
     *
     * @param  mixed  $uuid
     * @return bool
     */
    public function delete($uuid);
}
