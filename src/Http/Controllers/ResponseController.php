<?php

namespace Davidhsianturi\Compass\Http\Controllers;

use Davidhsianturi\Compass\Contracts\ResponseRepository;

class ResponseController
{
    /**
     * The docs repository.
     *
     * @var \Davidhsianturi\Compass\Contracts\ResponseRepository
     */
    protected $examples;

    /**
     * Create a new DocsController instance.
     *
     * @param  \Davidhsianturi\Compass\Contracts\ResponseRepository  $examples
     */
    public function __construct(ResponseRepository $examples)
    {
        $this->examples = $examples;
    }

    /**
     * Store the route documentation.
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return response()->json(
            $this->examples->save($this->validateRequest())
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
            $this->examples->find($uuid)
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
            $this->examples->delete($uuid),
            204
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
