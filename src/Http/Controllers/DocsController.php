<?php

namespace Davidhsianturi\Compass\Http\Controllers;

use Davidhsianturi\Compass\Contracts\DocsRepository;

class DocsController
{
    /**
     * The docs repository.
     *
     * @var \Davidhsianturi\Compass\Contracts\DocsRepository
     */
    protected $docs;

    /**
     * Create a new DocsController instance.
     *
     * @param  \Davidhsianturi\Compass\Contracts\DocsRepository  $docs
     */
    public function __construct(DocsRepository $docs)
    {
        $this->docs = $docs;
    }

    /**
     * Store the route documentation.
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return response()->json(
            $this->docs->save($this->validateRequest())
        );
    }

    /**
     * Show the route documentation by given UUID.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($uuid)
    {
        return response()->json(
            $this->docs->find($uuid)
        );
    }

    /**
     * Delete the route documentation by given UUID.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {
        return response()->json(
            $this->docs->delete($uuid), 204
        );
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'uuid' => 'sometimes|nullable',
            'route_hash' => 'required|string',
            'title' => 'required|string',
            'description' => 'nullable',
            'content' => 'required|array',
        ]);
    }
}
